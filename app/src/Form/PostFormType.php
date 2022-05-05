<?php

namespace App\Form;

use App\DataTransformer\Base64ToImageTransformer;
use App\DataTransformer\Post\RemoveHtmlTagsFromContentTransformer;
use App\DataTransformer\Post\RemoveHtmlTagsFromTitleTransformer;
use App\Dto\Post\PostInput;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Maciej Sobolak <maciek@koverlo.com>
 */
class PostFormType extends AbstractType
{
    public function __construct(
        private readonly Base64ToImageTransformer $base64ToImageTransformer,
        private readonly RemoveHtmlTagsFromTitleTransformer $removeHtmlTagsFromTitleTransformer,
        private readonly RemoveHtmlTagsFromContentTransformer $removeHtmlTagsFromContentTransformer
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('content', TextType::class)
            ->add('image', TextType::class);

        $builder->get('title')
            ->addModelTransformer($this->removeHtmlTagsFromTitleTransformer);

        $builder->get('content')
            ->addModelTransformer($this->removeHtmlTagsFromContentTransformer);

        $builder->get('image')
            ->addModelTransformer($this->base64ToImageTransformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PostInput::class,
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
