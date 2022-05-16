<?php

namespace App\Controller;

use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class BlogController extends AbstractController
{
    private $serializerInterface;
    public function __construct(SerializerInterface $serializerInterface)
    {
        $this->serializerInterface = $serializerInterface;
    }
    //SQL : SELECT * FROM Blog
    #[Route('/', methods: ['GET'] ,name: 'view_all_blog')] 
    public function viewAllBlog (BlogRepository $blogRepository) {
        //lấy dữ liệu từ bảng Blog trong database
        $blogs = $blogRepository->findAll();
        //convert dữ liệu thành chuẩn json (api)
        $json = $this->serializerInterface->serialize($blogs,'json');
        //return 1 response chứa dữ liệu theo format json
        return new Response($json, Response::HTTP_OK, 
        [
            'content-type' => 'application/json'
        ]);
    }

    //SQL : SELECT * FROM Blog WHERE id = $id
    #[Route('/{id}', methods: ['GET'], name: 'view_blog_by_id')]
    public function viewBlogById ($id, BlogRepository $blogRepository) {
        $blog = $blogRepository->find($id);
        //convert dữ liệu thành chuẩn xml (api)
        $xml = $this->serializerInterface->serialize($blog,'xml');
        //return 1 response chứa dữ liệu theo format xml
        return new Response($xml, 200, 
        [
            'content-type' => 'application/xml'
        ]);
    }
}   
