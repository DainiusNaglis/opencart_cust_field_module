<?php
class ControllerProductCategorieslist extends Controller{
    public function index(){
        $this->load->language('product/categorieslist');
        
        $this->document->setTitle($this->language->get('meta_title'));
        $this->document->setDescription($this->language->get('meta_description'));
        $this->document->setKeywords($this->language->get('meta_keyword'));
        
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('title'),
            'href' => $this->url->link('product/categorieslist')
        );
        
        $data['categories'] = array();
        $this->load->model('catalog/category');
        $results = $this->model_catalog_category->getCategories(0);
        
        $this->load->model('tool/image');
        
        foreach($results as $result){
            if($result['image']){
                $image = $this->model_tool_image->resize($result['image'],150, 150);
            }
            else{
                $image = $this->model_tool_image->resize('placeholder.png', 150, 150);
            }
            $data['categories'][] = array(
            'name'=>$result['name'],
            'image'=> $image,
            'href' => $this->url->link('product/category', 'path='.$result['category_id'])
            );
        }
        

        
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');
        
        $this->response->setOutput($this->load->view('product/categorieslist', $data));
    }
}