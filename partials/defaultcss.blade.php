{{favicon()}} 

<!-- Default css-->
@if($tema->isiCss=='')	
{{generate_theme_css('harmoni/assets/css/style.css')}} 
@else 	
{{generate_theme_css('harmoni/assets/css/editstyle.css')}} 
@endif	
{{generate_theme_css('harmoni/assets/css/jquery.fancybox.css')}} 
{{generate_theme_css('harmoni/assets/css/owl.carousel.css')}} 
{{generate_theme_css('harmoni/assets/css/owl.theme.css')}} 
