<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/', name: 'view_students')]
    public function viewStudents(ManagerRegistry $managerRegistry, StudentRepository $studentRepository) {
        //Cách 1 (không cần thêm parameter khi khai báo function)
        $students1 = $this->getDoctrine()->getRepository(Student::class)->findAll();
        //Cách 2 (cần có parameter ManagerRegistry khi khai báo function)
        $students2 = $managerRegistry->getRepository(Student::class)->findAll();
        //Cách 3 (cần có parameter của Repository khi khai báo function)
        $students3 = $studentRepository->findAll();
        //Note: chỉ sử dụng 1 cách để lấy dữ liệu từ DB
        return $this->render("student/index.html.twig",
        [
            'students' => $students3
        ]);
    }

    //Cách 1: tạo form trực tiếp từ Controller (not recommend)
    #[Route('/add', name: 'add_student')]
    public function addStudent(Request $request, ManagerRegistry $managerRegistry) {
        //B1: tạo 1 object cho entity để lưu dữ liệu nhập từ form
        $student = new Student;
        //B2: tạo form sử dụng hàm createFormBuilder()
        $form = $this->createFormBuilder($student)
                      ->add("Name", TextType::class)   //HTML: input type="text"
                      ->add("Age", IntegerType::class) 
                      ->add("Grade", NumberType::class)
                      ->add("Add", SubmitType::class)   //HTML: input type="submit"
                      ->getForm();
        //B3: handle request cho form
        $form->handleRequest($request);
        //B4: kiểm tra xem form đã được submit và dữ liệu đã được validate chưa
        if ($form->isSubmitted() && $form->isValid()) {
            //lưu dữ liệu từ entity vào DB
            //$manager = $this->getDoctrine()->getManager();
            //Note: nếu $this->getDoctrine() bị lỗi thì dùng ManagerRegistry để thay thế
            $manager = $managerRegistry->getManager();
            $manager->persist($student);
            $manager->flush();
            //redirect về trang index chứa dữ liệu của bảng từ database
            return $this->redirectToRoute("view_students");
        }
        //B5: render ra view chứa form
        //Cách 1: dùng hàm render() & createView()
        return $this->render("student/add.html.twig",
            [
                'studentForm' => $form->createView()
            ]
        );
    }

    //Cách 2: tạo form riêng và gọi đến trong Controller (recommend)
    #[Route('/create', name: 'create_student')]
    public function createStudent(Request $request) {
        $student = new Student;
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        $students = $this->getDoctrine()->getRepository(Student::class)->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            //check số lượng sinh viên hiện tại đã quá max quantity cho phép hay chưa
            //nếu chưa vượt quá thì add SV mới vào DB 
            //ngược lại thì trả về thông báo lỗi và không add
            $max_quantity = 5;
            if (count($students) <= $max_quantity) {
                $manager = $this->getDoctrine()->getManager(); //entity manager
                $manager->persist($student);
                $manager->flush();
            }
            return $this->redirectToRoute("view_students");
        }
        //dùng renderForm() thay cho render() để load form vào view (recommend)
        return $this->renderForm("student/add.html.twig",
        [
            'studentForm' => $form
        ]);
    }
}
