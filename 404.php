<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

$APPLICATION->SetTitle("404 Not Found");

?>

<section class="section section_padding-xxl">
    <div class="wrapper wrapper_mode-s wrapper-center">
        <h4 class="headline headline_size-h4 headline_color-white">404</h4>
        <h1 class="headline headline_size-h0 headline_color-white">
            Страница не найдена
        </h1>

        <p class="description description_size-p1 description_c-white">
            Возможно вы перешли на страницу, которой больше 
            <br/>
            не существует или не верно набрали адрес.
        </p>

        <a href="/" class="button button_theme-white button_size-m">Перейти на главную</a>
    </div>
</section>