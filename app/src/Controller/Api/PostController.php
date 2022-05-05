<?php

namespace App\Controller\Api;

use App\DataTransformer\Post\PostInputTransformer;
use App\DataTransformer\Post\PostOutputTransformer;
use App\Dto\Paginator\PaginatorDto;
use App\Dto\Post\PostInput;
use App\Dto\Post\PostOutput;
use App\Entity\Post;
use App\Form\Paginator\PaginatorForm;
use App\Form\PostFormType;
use App\Repository\PostRepository;
use App\Traits\RequestAwareTrait;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @author Maciej Sobolak <maciek@koverlo.com>
 */
#[OA\Tag(name: "Post")]
class PostController extends AbstractController
{
    use RequestAwareTrait;

    public function __construct(
        private readonly PostInputTransformer $postInputTransformer,
        private readonly PostOutputTransformer $postOutputTransformer,
        private readonly PostRepository $postRepository,
        private readonly SerializerInterface $serializer
    ) {
    }

    protected function getDefaultPaginator(): PaginatorDto
    {
        return new PaginatorDto(1, 5);
    }

    #[OA\RequestBody(
        description: "PostTypeForm",
        content: new OA\JsonContent(
            ref: new Model(type: PostInput::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: '',
        content: new OA\JsonContent(
            ref: new Model(type: PostOutput::class)
        )
    )]
    #[OA\Response(
        response: 400,
        description: 'Bad request. Check errors.'
    )]
    #[Route('/api/post', name: 'api_post', methods: 'POST')]
    public function createAction(ValidatorInterface $validator): Response
    {
        $postInput = new PostInput();

        $form = $this->createForm(PostFormType::class, $postInput)
            ->handleRequest($this->request);

        $errors = $validator->validate($form);

        if (count($errors) > 0) {
            return $this->returnResponse(['errors' => (string) $errors], Response::HTTP_BAD_REQUEST);
        }

        $post = $this->postInputTransformer->transform($postInput);
        $this->postRepository->add($post);

        return $this->returnResponse($this->postOutputTransformer->transform($post), Response::HTTP_CREATED);
    }

    #[OA\Parameter(
        name: 'pageNumber',
        description: 'Page number for pagination.',
        in: 'query',
        schema: new OA\Schema(type: 'int')
    )]
    #[OA\Parameter(
        name: 'pageSize',
        description: 'Number of records for each page.',
        in: 'query',
        schema: new OA\Schema(type: 'int')
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns an array of posts.',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: PostOutput::class))
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'No posts were found.'
    )]
    #[Route('/api/post', name: 'api_post_list', methods: 'GET')]
    public function listAction(): JsonResponse
    {
        $paginator = $this->getPaginator();
        $posts = $this->postRepository->findAllPosts($paginator);

        if (!$posts) {
            return new JsonResponse(['errors' => 'No posts were found.'], Response::HTTP_NOT_FOUND);
        }

        $response = [
            "data" => array_map(function (Post $post) {
                return $this->postOutputTransformer->transform($post);
            }, $posts),
            "paginator" => $paginator
        ];

        return $this->returnResponse($response);
    }

    #[OA\Response(
        response: 200,
        description: 'Returns the Post from the given UUID.',
        content: new OA\JsonContent(
            ref: new Model(type: PostOutput::class)
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Post with the given UUID was not found.'
    )]
    #[Route('/api/post/{uuid}', name: 'api_post_get_by_uuid', methods: 'GET')]
    public function getByUuidAction($uuid): JsonResponse
    {
        $post = $this->postRepository->findOneBy(['uuid' => $uuid]);

        if (!$post) {
            return $this->returnResponse(['errors' => 'Post with the given UUID was not found.'], Response::HTTP_NOT_FOUND);
        }

        return $this->returnResponse($this->postOutputTransformer->transform($post));
    }

    private function returnResponse(mixed $data, $status = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse($this->serializer->serialize($data, 'json'), status: $status, json: true);
    }

    protected function getPaginator(): PaginatorDto
    {
        $paginator = $this->getDefaultPaginator();
        $this->createForm(PaginatorForm::class, $paginator)
            ->handleRequest($this->request);

        return $paginator;
    }
}
