<?xml version="1.0" standalone="no"?>
<EasyView Name="{$type_view_name}" 
	Description="{$type_view_desc}" 
	Class="EasyView" 
	Access="{$acl.access}" 
	TemplateEngine="Smarty" 
	TemplateFile="view.tpl">
   <FormReferences>
   		<Reference Name="{$default_form_name}"/>
   </FormReferences>       
</EasyView>