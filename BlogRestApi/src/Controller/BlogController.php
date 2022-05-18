<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    //INSERT INTO Blog ....
    #[Route('/', methods: ['POST'], name: 'add_new_blog')]
    public function addBlog (Request $request, ManagerRegistry $managerRegistry) {
        //tạo mới 1 object Blog
        $blog = new Blog;
        //decode dữ liệu từ request của client
        $data = json_decode($request->getContent(),true);
        //set dữ liệu tương ứng cho object sử dụng setter
        $blog->setTitle($data['title']);
        $blog->setAuthor($data['author']);
        $blog->setContent($data['content']);
        $blog->setDate(\DateTime::createFromFormat('Y-m-d',$data['date']));
        //lưu dữ liệu từ object vào database
        //$manager = $this->getDoctrine()->getManager();
        $manager = $managerRegistry->getManager();
        $manager->persist($blog);
        $manager->flush();
        //trả về Response cho client 
        return new Response(null,Response::HTTP_CREATED); //code = 201
    }

    //UPDATE Blog SET ... WHERE id = $id
    #[Route('/{id}', methods: ['PUT'], name: 'edit_blog')]
    public function editBlog ($id, Request $request, ManagerRegistry $managerRegistry) {
        //lấy ra Blog cần edit trong DB theo id
        $blog = $managerRegistry->getRepository(Blog::class)->find($id);
        //check xem Blog này có tồn tại trong DB không
        if ($blog == null) {
            return new Response("Blog not found", Response::HTTP_BAD_REQUEST); //code = 400
        }
        //decode request từ client
        $data = json_decode($request->getContent(),true);
        //sử dụng setter để set dữ liệu mới cho object Blog
        $blog->setTitle($data['title']);
        $blog->setAuthor($data['author']);
        $blog->setContent($data['content']);
        $blog->setDate(\DateTime::createFromFormat('Y-m-d',$data['date']));
        //lưu dữ liệu vào DB
        $manager = $managerRegistry->getManager();
        $manager->persist($blog);
        $manager->flush();
        //trả response về client
        return new Response("Blog has been updated successfully !", Response::HTTP_ACCEPTED); //code = 202
    }
}   
