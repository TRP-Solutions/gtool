<?php
trait htmlDesignNodeParent {
	public function button($value, $onclick) {
		$input = $this->el('input',['type'=>'button','value'=>$value]);
		if($onclick) {
			$input->at(['onclick'=>$onclick]);
		}
		return $input;
	}
	public function form($action = null, $method = 'get'){
		$form = $this->el('form');
		if(!empty($action)){
			$form->at(['action'=>$action,'method'=>$method]);
		} else {
			$form->at(['onsubmit'=>'return false;']);
		}
		return $form;
	}
	public function label($text = '', $for = null){
		$label = $this->el('label');
		$label->te($text);
		if(!is_null($for))
			$label->at(['for'=>$for]);
		return $label;
	}
	public function input($name, $id = null, $value = null){
		$input = $this->el('input',['name'=>$name]);
		if(!is_null($id))
			$input->at(['id'=>$id]);
		if(!is_null($value))
			$input->at(['value'=>$value]);
		return $input;
	}
	public function select($name, $id = null){
		$select = $this->el('select',['name'=>$name]);
		if(!is_null($id))
			$select->at(['id'=>$id]);
		return $select;
	}
	public function option($text, $value = null, $selected = false){
		$option = $this->el('option');
		$option->te($text);
		if(!is_null($value))
			$option->at(['value'=>$value]);
		if($selected)
			$option->at(['selected']);
		return $option;
	}
	public function submit($value = null){
		$submit = $this->el('input',['type'=>'submit']);
		if(!is_null($value))
			$submit->at(['value'=>$value]);
		return $submit;
	}
	public function hidden($name, $value){
		$hidden = $this->el('input',['type'=>'hidden','name'=>$name,'value'=>$value]);
		return $hidden;
	}
	public function textarea($name, $content = '') {
		$textarea = $this->el('textarea',['id'=>$name,'name'=>$name]);
		$textarea->te($content);
		return $textarea;
	}
	public function file($name, $multiple = false) {
		$input = $this->el('input',['type'=>'file','id'=>$name]);
		if($multiple) {
			$input->at(['multiple','name'=>$name.'[]']);
		}
		else {
			$input->at(['name'=>$name]);
		}
		return $input;
	}
	public function el($name, $attributes = [], $append = false){
		$element = static::createDesignElement($name);
		$this->appendChild($element);
		$element->at($attributes,$append);
		return $element;
	}
	protected static function createDesignElement($name){
		return new htmlDesignElement($name);
	}
}

class htmlDesign extends HealDocument {
	use htmlDesignNodeParent;
}

class htmlDesignElement extends HealElement {
	use htmlDesignNodeParent;
}
