<?php
class Design extends HealPlugin {
	public static function button($parent, $value, $onclick) {
		$input = $parent->el('input',['type'=>'button','value'=>$value]);
		if($onclick) {
			$input->at(['onclick'=>$onclick]);
		}
		return $input;
	}
	public static function form($parent, $action = null, $method = 'get'){
		$form = $parent->el('form');
		if(!empty($action)){
			$form->at(['action'=>$action,'method'=>$method]);
		} else {
			$form->at(['onsubmit'=>'return false;']);
		}
		return $form;
	}
	public static function label($parent, $text = '', $for = null){
		$label = $parent->el('label');
		$label->te($text);
		if(!is_null($for))
			$label->at(['for'=>$for]);
		return $label;
	}
	public static function input($parent, $name, $id = null, $value = null){
		$input = $parent->el('input',['name'=>$name]);
		if(!is_null($id))
			$input->at(['id'=>$id]);
		if(!is_null($value))
			$input->at(['value'=>$value]);
		return $input;
	}
	public static function select($parent, $name, $id = null){
		$select = $parent->el('select',['name'=>$name]);
		if(!is_null($id))
			$select->at(['id'=>$id]);
		return $select;
	}
	public static function option($parent, $text, $value = null, $selected = false){
		$option = $parent->el('option');
		$option->te($text);
		if(!is_null($value))
			$option->at(['value'=>$value]);
		if($selected)
			$option->at(['selected']);
		return $option;
	}
	public static function submit($parent, $value = null){
		$submit = $parent->el('input',['type'=>'submit']);
		if(!is_null($value))
			$submit->at(['value'=>$value]);
		return $submit;
	}
	public static function hidden($parent, $name, $value){
		$hidden = $parent->el('input',['type'=>'hidden','name'=>$name,'value'=>$value]);
		return $hidden;
	}
	public static function textarea($parent, $name, $content = ''){
		$textarea = $parent->el('textarea',['id'=>$name,'name'=>$name]);
		$textarea->te($content);
		return $textarea;
	}
	public static function file($parent, $name, $multiple = false){
		$input = $parent->el('input',['type'=>'file','id'=>$name]);
		if($multiple) {
			$input->at(['multiple','name'=>$name.'[]']);
		}
		else {
			$input->at(['name'=>$name]);
		}
		return $input;
	}
}

HealDocument::register_plugin('Design');
