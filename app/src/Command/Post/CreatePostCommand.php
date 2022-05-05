<?php

declare(strict_types=1);

namespace App\Command\Post;

use App\DataTransformer\Base64ToImageTransformer;
use App\DataTransformer\Post\PostInputTransformer;
use App\DataTransformer\Post\RemoveHtmlTagsFromContentTransformer;
use App\DataTransformer\Post\RemoveHtmlTagsFromTitleTransformer;
use App\Dto\Post\PostInput;
use App\Repository\PostRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @author Maciej Sobolak <maciek@koverlo.com>
 */
final class CreatePostCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create-post';
    protected static $defaultDescription = 'Creates a new Post.';

    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly Base64ToImageTransformer $base64ToImageTransformer,
        private readonly PostInputTransformer $postInputTransformer,
        private readonly PostRepository $postRepository,
        private readonly RemoveHtmlTagsFromTitleTransformer $removeHtmlTagsFromTitleTransformer,
        private readonly RemoveHtmlTagsFromContentTransformer $removeHtmlTagsFromContentTransformer,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('title', InputArgument::REQUIRED, 'Title.')
            ->addArgument('content', InputArgument::REQUIRED, 'Content.')
            ->addArgument('image', InputArgument::REQUIRED, 'Image Base64.');

        $this
            ->setHelp('This command allows you to create a new Post.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $postInput = new PostInput();

        $title = $this->removeHtmlTagsFromTitleTransformer->reverseTransform($input->getArgument("title"));
        $content = $this->removeHtmlTagsFromContentTransformer->reverseTransform($input->getArgument("content"));
        $image = $this->base64ToImageTransformer->reverseTransform($input->getArgument("image"));

        $postInput
            ->setTitle($title)
            ->setContent($content)
            ->setImage($image);

        $errors = $this->validator->validate($postInput);

        if (count($errors) > 0) {
            $output->writeln((string) $errors);
            return Command::INVALID;
        }

        $post = $this->postInputTransformer->transform($postInput);
        $this->postRepository->add($post);

        $output->writeln("CREATED");

        return Command::SUCCESS;
    }
}
