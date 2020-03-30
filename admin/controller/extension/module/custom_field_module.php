<?php
class ControllerExtensionModuleCustomFieldModule extends Controller{
    
    public function index(){
        $this->load->language('extension/module/custom_field_module');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('module/custom_field_module');

		$this->getList();
	}
    
    public function add() {
		$this->load->language('extension/module/custom_field_module');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('module/custom_field_module');


        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            $this->model_module_custom_field_module->insertDataInTable($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module/custom_field_module', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->addForm();
	}
    
    public function edit() {
		$this->load->language('extension/module/custom_field_module');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('module/custom_field_module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_module_custom_field_module->editCustomField($this->request->get['custom_field_module_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module/custom_field_module', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->addForm();
	}
    
    public function delete() {
		$this->load->language('extension/module/custom_field_module');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('module/custom_field_module');

		if (isset($this->request->post['selected']) && $this->validate()) {
			foreach ($this->request->post['selected'] as $custom_field_module_id) {
				$this->model_module_custom_field_module->deleteCustomField($custom_field_module_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module/custom_field_module', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}
    
    public function getList(){

		$url = '';

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/custom_field_module', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('extension/module/custom_field_module/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('extension/module/custom_field_module/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['custom_fields'] = array();
        
        $results = $this->model_module_custom_field_module->getCustomFields();
        
        foreach ($results as $result) {

			$data['custom_fields'][] = array(
				'custom_field_module_id' => $result['custom_field_module_id'],
				'custom_field_name'            => $result['custom_field_name'],
				'custom_field_key'        => $result['custom_field_key'],
				'edit'            => $this->url->link('extension/module/custom_field_module/edit', 'user_token=' . $this->session->data['user_token'] . '&custom_field_module_id=' . $result['custom_field_module_id'] . $url, true)
			);
		}
        
        $data['key_values'] = array();
        
        $keyvalues = $this->model_module_custom_field_module->getCustomFieldKey();
        
        foreach ($keyvalues as $keyalue) {

			$data['key_values'][] = array(
				'custom_field_key'      => $keyalue['custom_field_key'],
				'custom_field_name'     => $keyalue['custom_field_name'],
				'custom_field_value'    => html_entity_decode($keyalue['custom_field_value'], ENT_QUOTES, 'UTF-8'),
                'custom_field_status'   => $keyalue['custom_field_status']
			);
		}

        if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/custom_field_module_list', $data));
        
    }
    
    public function addForm()
    {
        $data['text_form'] = !isset($this->request->get['custom_field_module_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        
        $this->load->language('extension/module/custom_field_module');
        $this->load->model('module/custom_field_module');
        $this->document->setTitle($this->language->get('heading_title'));

//        if(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()){
//            $this->load->model('setting/setting');
//            $this->model_setting_setting->editSetting('module_login', $this->request->post);
//            $this->session->data['success'] = $this->language->get('text_success');
//            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
//        }
        
        if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
        
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
        );
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/custom_field_module', 'user_token=' . $this->session->data['user_token'])
        );
        
        $url = '';
        
        if (!isset($this->request->get['custom_field_module_id'])) {
			$data['action'] = $this->url->link('extension/module/custom_field_module/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('extension/module/custom_field_module/edit', 'user_token=' . $this->session->data['user_token'] . '&custom_field_module_id=' . $this->request->get['custom_field_module_id'] . $url, true);
		}

        $data['cancel'] = $this->url->link('extension/module/custom_field_module', 'user_token=' . $this->session->data['user_token'] . $url, true);
        
        $this->load->model('setting/store');

		$data['stores'] = array();

		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->language->get('text_default')
		);

		$stores = $this->model_setting_store->getStores();

        $this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();
        
		foreach ($stores as $store) {
			$data['stores'][] = array(
				'store_id' => $store['store_id'],
				'name'     => $store['name']
			);
		}
        
        if(isset($this->request->get['custom_field_module_id'])){
        $data['check'] = $this->request->get['custom_field_module_id'];
        }
            
        if (isset($this->request->get['custom_field_module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$custom_field_module_info = $this->model_module_custom_field_module->getCustomField($this->request->get['custom_field_module_id']);
		}
        
        
        if (isset($this->request->post['type'])) {
			$data['type'] = $this->request->post['type'];
		} elseif (!empty($custom_field_module_info)) {
            $data['type'] = $custom_field_module_info['custom_field_type'];
        }
        else {
			$data['type'] = '';
		}
        
        if (isset($this->request->post['input_key'])) {
			$data['input_key'] = $this->request->post['input_key'];
		} elseif (!empty($custom_field_module_info)) {
            $data['input_key'] = $custom_field_module_info['custom_field_key'];
        } else {
			$data['input_key'] = '';
		}
             
        
        if (isset($this->request->post['module_custom_field_status'])) {
			$data['module_custom_field_status'] = $this->request->post['module_custom_field_status'];
		} elseif (!empty($custom_field_module_info)) {
            $data['module_custom_field_status'] = $custom_field_module_info['custom_field_status'];
        } else {
			$data['module_custom_field_status'] = '';
		}
        
        if (isset($this->request->post['language'])) {
			$data['language'] = $this->request->post['language'];
		} elseif (!empty($custom_field_module_info)) {
            $data['language'] = $custom_field_module_info['custom_field_language'];
        } else {
			$data['language'] = '';
		}
        
        if (isset($this->request->post['input_custom_field_name'])) {
			$data['input_custom_field_name'] = $this->request->post['input_custom_field_name'];
		} elseif (!empty($custom_field_module_info)) {
            $data['input_custom_field_name'] = $custom_field_module_info['custom_field_name'];
        } else {
			$data['input_custom_field_name'] = '';
		}
        
        if (isset($this->request->post['value'])) {
			$data['value'] = $this->request->post['value'];
		} elseif (!empty($custom_field_module_info)) {
            $data['value'] = $custom_field_module_info['custom_field_value'];
            $data['value'] = html_entity_decode($data['value']);
            $data['value'] = strip_tags($data['value']);
        } else {
			$data['value'] = '';
		}

        
		if (isset($this->request->post['textarea_value'])) {
			$data['textarea_value'] = $this->request->post['textarea_value'];
		} elseif (!empty($custom_field_module_info)) {
            $data['textarea_value'] = $custom_field_module_info['custom_field_value'];
        } else {
			$data['textarea_value'] = '';
		}

        if (isset($this->request->post['custom_field_module_store'])) {
			$data['custom_field_module_store'] = $this->request->post['custom_field_module_store'];
		} elseif (isset($this->request->get['custom_field_module_id'])) {
			$data['custom_field_module_store'] = $this->model_module_custom_field_module->getCustomFieldsStores($this->request->get['custom_field_module_id']);
		} else {
			$data['custom_field_module_store'] = array(0);
		}
        

        
//        if(isset($this->request->post['module_custom_field_status'])){
//            $data['module_custom_field_status'] = $this->request->post['module_custom_field_status'];
//        }
//        else{
//            $data['module_custom_field_status'] = $this->config->get('module_custom_field_status');
//        }

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $this->response->setOutput($this->load->view('extension/module/custom_field_module_form', $data));
    }
    
    
    
    
    
    
    protected function validate(){
        if(!$this->user->hasPermission('modify', 'extension/module/custom_field_module')){
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return !$this->error;
    }
}

