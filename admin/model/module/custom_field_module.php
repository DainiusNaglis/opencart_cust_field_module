<?php
class ModelModuleCustomFieldModule extends Model {
    
    public function getCustomFieldStores($custom_field_module_id) {
		$custom_field_module_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "custom_field_module_to_store WHERE custom_field_module_id = '" . (int)$custom_field_module_id . "'");

		foreach ($query->rows as $result) {
			$custom_field_module_store_data[] = $result['custom_field_module_id'];
		}

		return $custom_field_module_store_data;
	}
    
    public function insertDataInTable($data){
        
        if((isset($data['textarea_value'])) && !empty($data['textarea_value']) && empty($data['value']))
            {
//            $data['values'] = html_entity_decode($data['values']);
//            $data['values'] = strip_tags($data['values']);
            
        $this->db->query("INSERT INTO " . DB_PREFIX . "custom_field_module SET custom_field_type = '" . $this->db->escape($data['type']) . "', custom_field_key = '" . $this->db->escape($data['input_key']) . "', custom_field_status = '" . (int)$data['module_custom_field_status'] . "', custom_field_language = '" . (int)$data['language'] . "', custom_field_name = '" . $this->db->escape($data['input_custom_field_name']) . "', custom_field_value = '" . $this->db->escape($data['textarea_value']) . "'");
            }
            
            if((isset($data['value'])) && !empty($data['value']) && empty($data['textarea_value']))
               {
                   $this->db->query("INSERT INTO " . DB_PREFIX . "custom_field_module SET custom_field_type = '" . $this->db->escape($data['type']) . "', custom_field_key = '" . $this->db->escape($data['input_key']) . "', custom_field_status = '" . (int)$data['module_custom_field_status'] . "', custom_field_language = '" . (int)$data['language'] . "', custom_field_name = '" . $this->db->escape($data['input_custom_field_name']) . "', custom_field_value = '" . $this->db->escape($data['value']) . "'");
               }
                
        $custom_field_module_id = $this->db->getLastId();
        
        if (isset($data['custom_field_module_store'])) {
			foreach ($data['custom_field_module_store'] as $custom_field_module_store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "custom_field_module_to_store SET custom_field_module_id = '" . (int)$custom_field_module_id . "', store_id = '" . (int)$custom_field_module_store_id . "'");
			}
		}
    }
    
    
    	public function getCustomField($custom_field_module_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "custom_field_module` cfm LEFT JOIN " . DB_PREFIX . "custom_field_module_to_store cfmts ON (cfm.custom_field_module_id = cfmts.custom_field_module_id) WHERE cfm.custom_field_module_id = '" . (int)$custom_field_module_id . "'");

		return $query->row;
	}
    
    
        public function getCustomFieldKey(){
            $query = $this->db->query("SELECT custom_field_name, custom_field_status, custom_field_value, custom_field_key FROM " . DB_PREFIX . "custom_field_module");

            return $query->rows;
        }
    
    
    	public function editCustomField($custom_field_module_id, $data) {
            
        if($data['type'] == 'textarea')
        {
		$this->db->query("UPDATE `" . DB_PREFIX . "custom_field_module` SET custom_field_type = '" . $this->db->escape($data['type']) . "', custom_field_key = '" . $this->db->escape($data['input_key']) . "', custom_field_status = '" . (int)$data['module_custom_field_status'] . "', custom_field_language = '0', custom_field_name = '" . $this->db->escape($data['input_custom_field_name']) . "', custom_field_value = '" . $this->db->escape($data['textarea_value']) . "' WHERE custom_field_module_id = '" . (int)$custom_field_module_id . "'");
        }
            
        if($data['type'] == 'text')
        {
		$this->db->query("UPDATE `" . DB_PREFIX . "custom_field_module` SET custom_field_type = '" . $this->db->escape($data['type']) . "', custom_field_key = '" . $this->db->escape($data['input_key']) . "', custom_field_status = '" . (int)$data['module_custom_field_status'] . "', custom_field_language = '0', custom_field_name = '" . $this->db->escape($data['input_custom_field_name']) . "', custom_field_value = '" . $this->db->escape($data['value']) . "' WHERE custom_field_module_id = '" . (int)$custom_field_module_id . "'");
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "custom_field_module_to_store WHERE custom_field_module_id = '" . (int)$custom_field_module_id . "'");
            
        if (isset($data['custom_field_module_store'])) {
			foreach ($data['custom_field_module_store'] as $custom_field_module_store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "custom_field_module_to_store SET custom_field_module_id = '" . (int)$custom_field_module_id . "', store_id = '" . (int)$custom_field_module_store_id . "'");
			}
		}
	}
    
    
    	public function getCustomFieldsStores($custom_field_module_id) {
		$custom_field_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "custom_field_module_to_store WHERE custom_field_module_id = '" . (int)$custom_field_module_id . "'");

		foreach ($query->rows as $result) {
			$custom_field_store_data[] = $result['store_id'];
		}

		return $custom_field_store_data;
	}
    
    
    
    
    
    
    public function deleteCustomField($custom_field_module_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "custom_field_module` WHERE custom_field_module_id = '" . (int)$custom_field_module_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "custom_field_module_to_store` WHERE custom_field_module_id = '" . (int)$custom_field_module_id . "'");
	}
    
    public function getCustomFields() {
		
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "custom_field_module");
		return $query->rows;
	}
}

//<?php
//class ModelModuleLogin extends Model {
//    
//    public function getLoginStores($login_id) {
//		$login_store_data = array();
//
//		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "login_to_store WHERE login_id = '" . (int)$login_id . "'");
//
//		foreach ($query->rows as $result) {
//			$login_store_data[] = $result['store_id'];
//		}
//
//		return $login_store_data;
//	}
//    
//    public function insertDataInTable($data){
//        
//        if((isset($data['values'])) && !empty($data['values']))
//            {
//            $data['values'] = html_entity_decode($data['values']);
//            $data['values'] = strip_tags($data['values']);
//            
//        $this->db->query("INSERT INTO " . DB_PREFIX . "custom_field_module SET custom_field_type = '" . $this->db->escape($data['type']) . "', custom_field_key = '" . $this->db->escape($data['input_key']) . "', custom_field_status = '" . (int)$data['module_login_status'] . "', custom_field_language = '" . (int)$data['language'] . "', custom_field_name = '" . $this->db->escape($data['input_custom_field_name']) . "', custom_field_value = '" . $this->db->escape($data['values']) . "'");
//            }
//            
//            if((isset($data['value'])) && !empty($data['value']))
//               {
//                   $this->db->query("INSERT INTO " . DB_PREFIX . "custom_field_module SET custom_field_type = '" . $this->db->escape($data['type']) . "', custom_field_key = '" . $this->db->escape($data['input_key']) . "', custom_field_status = '" . (int)$data['module_login_status'] . "', custom_field_language = '" . (int)$data['language'] . "', custom_field_name = '" . $this->db->escape($data['input_custom_field_name']) . "', custom_field_value = '" . $this->db->escape($data['value']) . "'");
//               }
//                
//        $custom_field_module_id = $this->db->getLastId();
//        
//        if (isset($data['login_store'])) {
//			foreach ($data['login_store'] as $store_id) {
//				$this->db->query("INSERT INTO " . DB_PREFIX . "custom_field_module_to_store SET custom_field_module_id = '" . (int)$custom_field_module_id . "', store_id = '" . (int)$store_id . "'");
//			}
//		}
//    }
//    
//    
//    
//    
//}