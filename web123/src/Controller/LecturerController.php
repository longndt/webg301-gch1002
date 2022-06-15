<?php

namespace App\Controller;

use App\Entity\Lecturer;
use App\Form\LecturerType;
use App\Repository\LecturerRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

use function PHPUnit\Framework\throwException;

/**
 * @IsGranted("ROLE_MANAGER")
 */
#[Route('/lecturer')]
class LecturerController extends AbstractController
{
    #[Route('/ ', name: 'view_lecturer_list')]
    public function LecturerIndex(LecturerRepository $lecturerRepository) {
        $lecturers = $lecturerRepository->viewAllLecturer();
        return $this->render("lecturer/index.html.twig",
        [
            'lecturers' => $lecturers
        ]);
    }

    #[Route('/detail/{id}', name: 'view_lecturer_by_id')]
    public function LecturerDetail(ManagerRegistry $managerRegistry, $id) {
        $lecturer = $managerRegistry->getRepository(Lecturer::class)->find($id);
        return $this->render("lecturer/detail.html.twig",
        [
            'lecturer' => $lecturer
        ]);
    }

    #[Route('/delete/{id}', name: 'delete_lecturer')]
    public function LecturerDelete(ManagerRegistry $managerRegistry, $id) {
        $lecturer = $managerRegistry->getRepository(Lecturer::class)->find($id);
        if ($lecturer == null) {
            $this->addFlash("Error","Lecturer not found !");        
        } 
        else if (count($lecturer->getCourse()) >= 1 ) {
            $this->addFlash("Error","Can not delete this lecturer !");
        }
        else {
            $manager = $managerRegistry->getManager();
            $manager->remove($lecturer);
            $manager->flush();
            $this->addFlash("Success","Delete lecturer succeed  !");
        }
        return $this->redirectToRoute("view_lecturer_list");
    }

    #[Route('/add', name: 'add_lecturer')]
    public function LecturerAdd(Request $request) {
        $lecturer = new Lecturer;
        $form = $this->createForm(LecturerType::class,$lecturer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //code xử lý việc upload ảnh
            //B1: tạo 1 biến để lấy dữ liệu ảnh được upload từ form
            $image = $lecturer->getImage();
            //B2: tạo tên mới cho ảnh => đảm bảo tên ảnh là duy nhất
            $imgName = uniqid(); //unique id
            //B3: lấy đuôi (extension) của file ảnh
            //Note: cần xóa data type "string" trong getter & setter của file Entity
            $imgExtension = $image->guessExtension();
            //B4: tạo tên file hoàn thiện cho ảnh (tên mới + đuôi cũ)
            $imageName = $imgName . "." . $imgExtension;
            //B5: di chuyển file ảnh đến thư mục chỉ định ở trong project  
            //Note1: cần tạo thư mục chứa ảnh trong public
            //Note2: cấu hình parameter trong file services.yaml (thư mục config)
             try {
                $image->move (
                    $this->getParameter('lecturer_image'),$imageName
                );
            } catch (FileException $e) {
                throwException($e);
            }
            //B6: lưu tên ảnh vào trong DB
            $lecturer->setImage($imageName);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($lecturer);
            $manager->flush();
            $this->addFlash("Success","Add lecturer succeed !");
            return $this->redirectToRoute("view_lecturer_list");
        }
        return $this->renderForm("lecturer/add.html.twig",
        [
            'lecturerForm' => $form
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_lecturer')]
    public function LecturerEdit(Request $request, ManagerRegistry $managerRegistry, $id) {
        $lecturer = $managerRegistry->getRepository(Lecturer::class)->find($id);
        if ($lecturer == null) {
            $this->addFlash("Error","Lecturer not found !");
            return $this->redirectToRoute("view_lecturer_list");        
        } else {
            $form = $this->createForm(LecturerType::class,$lecturer);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                //kiểm tra xem người dùng có muốn upload ảnh mới hay không
                //nếu có thì thực hiện code upload ảnh
                //nếu không thì bỏ qua
                $imageFile = $form['image']->getData();
                if ($imageFile != null) {
                    //B1: tạo 1 biến để lấy dữ liệu ảnh được upload từ form
                    $image = $lecturer->getImage();
                    //B2: tạo tên mới cho ảnh => đảm bảo tên ảnh là duy nhất
                    $imgName = uniqid(); //unique id
                    //B3: lấy đuôi (extension) của file ảnh
                    //Note: cần xóa data type "string" trong getter & setter của file Entity
                    $imgExtension = $image->guessExtension();
                    //B4: tạo tên file hoàn thiện cho ảnh (tên mới + đuôi cũ)
                    $imageName = $imgName . "." . $imgExtension;
                    //B5: di chuyển file ảnh đến thư mục chỉ định ở trong project
                    //Note1: cần tạo thư mục chứa ảnh trong public
                    //Note2: cấu hình parameter trong file services.yaml (thư mục config)
                    try {
                        $image->move(
                            $this->getParameter('lecturer_image'),
                            $imageName
                        );
                    } catch (FileException $e) {
                        throwException($e);
                    }
                    //B6: lưu tên ảnh vào trong DB
                    $lecturer->setImage($imageName);
                }
                $manager = $managerRegistry->getManager();
                $manager->persist($lecturer);
                $manager->flush();
                $this->addFlash("Success","Edit lecturer succeed !");
                return $this->redirectToRoute("view_lecturer_list");
            }
            return $this->renderForm("lecturer/edit.html.twig",
            [
                'lecturerForm' => $form
            ]);
        }   
    }
}
