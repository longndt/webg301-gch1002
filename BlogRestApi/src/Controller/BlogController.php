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
        //$blogs = $this->getDoctrine()->getRepository(Blog::class)->findAll();
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
        //kiểm tra xem dữ liệu có tồn tại trong DB không
        //TH1: không tồn tại
        if ($blog == null) {
            return new Response("Blog not found", Response::HTTP_NOT_FOUND); //code = 404
        }
        //TH2: có tồn tại
        //convert dữ liệu thành chuẩn xml (api)
        $xml = $this->serializerInterface->serialize($blog,'xml');
        //return 1 response chứa dữ liệu theo format xml
        return new Response($xml, 200, 
        [
            'content-type' => 'application/xml'
        ]);
    }

    //DELETE FROM Blog WHERE id = $id
    #[Route('/{id}', methods: ['DELETE'], name: 'delete_blog')]
    public function deleteBlog ($id, BlogRepository $blogRepository) {
        $blog = $blogRepository->find($id);
        if ($blog != null) {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($blog);
            $manager->flush();
            return new Response(null, Response::HTTP_NO_CONTENT);
        } else {
            return new Response("Blog not found", 404);
        }
    }
    
}   
