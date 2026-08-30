<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<section class="t2030trends bgblue" style="posiiton:relative; z-index:2;">
    <div class="container">
        <?php $APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list",
            "tyumen2030",
            Array(
                "COMPONENT_TEMPLATE" => ".default",
                "IBLOCK_TYPE" => "t2030",	// Тип инфоблока
                "IBLOCK_ID" => "32",	// Инфоблок
                "SECTION_ID" => "",	// ID раздела
                "SECTION_CODE" => "",	// Код раздела
                "COUNT_ELEMENTS" => "Y",	// Показывать количество элементов в разделе
                "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",	// Показывать количество
                "TOP_DEPTH" => "2",	// Максимальная отображаемая глубина разделов
                "SECTION_FIELDS" => array(	// Поля разделов
                    0 => "",
                    1 => "",
                ),
                "SECTION_USER_FIELDS" => array(	// Свойства разделов
                    0 => "",
                    1 => "",
                ),
                "FILTER_NAME" => "sectionsFilter",	// Имя массива со значениями фильтра разделов
                "VIEW_MODE" => "LINE",	// Вид списка подразделов
                "SHOW_PARENT_NAME" => "Y",	// Показывать название раздела
                "SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
                "CACHE_TYPE" => "A",	// Тип кеширования
                "CACHE_TIME" => "36000000",	// Время кеширования (сек.)
                "CACHE_GROUPS" => "Y",	// Учитывать права доступа
                "CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
                "ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
            ),
            false
        ); ?>
    </div>
</section>
<div id="particles-js"></div>
<section style="posiiton:relative; z-index:2;" class="t2030trends bgblue">
    <div class="container">
        <p class="t1920 ttu">Глобальные мегатренды</p>
        <div class="trendswrapper">
            <div class="newswrapper">
                <a class="newsitm">
                    <div class="post newsitmimg" style="background: url('/images/2030/20301.jpg') no-repeat;"></div>
                    <video id="myvideo" class="newsitmimg"  poster="/images/2030/20301.jpg">
                        <source src="/images/2030/cifr.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                    </video>
                    <style>
                        .newsitm #myvideo{
                            height: 380px;
                            width:initial;}
                    </style>

                    <div class="bgover"></div>
                    <div class="newsitmc">
                        <p class="textcenter trendstitle">цифровизация</p>
                    </div>
                </a>
                <a class="newsitm">
                    <div class="post newsitmimg" style="background: url('/images/2030/2.jpg') no-repeat;"></div>
                    <video id="myvideo1" class="newsitmimg"  poster="/images/2030/2.jpg">
                        <source src="/images/2030/peop.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                    </video>
                    <style>
                        .newsitm #myvideo1{
                            height: 380px;
                            width:initial;}
                    </style>

                    <div class="bgover"></div>
                    <div class="newsitmc">
                        <p class="textcenter trendstitle">высокое качество услуг для человека</p>
                    </div>
                </a>
                <a class="newsitm">
                    <div class="post newsitmimg" style="background: url('/images/2030/3.jpg') no-repeat;"></div>
                    <video id="myvideo2" class="newsitmimg"  poster="/images/2030/3.jpg">
                        <source src="/images/2030/autop.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                    </video>
                    <style>
                        .newsitm #myvideo2{
                            height: 780px;
                            width:initial;}
                    </style>

                    <div class="bgover"></div>
                    <div class="newsitmc">
                        <p class="textcenter trendstitle">автоматизация производства</p>
                    </div>
                </a>
                <a class="newsitm">
                    <div class="post newsitmimg" style="background: url('/images/2030/4.jpg') no-repeat;"></div>
                    <video id="myvideo3" class="newsitmimg"  poster="/images/2030/4.jpg">
                        <source src="/images/2030/eco.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                    </video>
                    <style>
                        .newsitm #myvideo3{
                            height: 380px;
                            width:initial;}
                    </style>
                    <div class="bgover"></div>
                    <div class="newsitmc">
                        <p class="textcenter trendstitle">экологичная экономика</p>
                    </div>
                </a>
                <a class="newsitm">
                    <div class="post newsitmimg" style="background: url('/images/2030/5.jpg') no-repeat;"></div>
                    <video id="myvideo3" class="newsitmimg"  poster="/images/2030/5.jpg">
                        <source src="/images/2030/trans.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                    </video>
                    <style>
                        .newsitm #myvideo3{
                            height: 380px;
                            width:initial;}
                    </style>
                    <script>
                        $(document).ready(function(){
                            $(".newsitm").hover(

                                function() {

                                    $(this).children("video").get(0).play();
                                    $(this).children(".post").hide();
                                }, function() {
                                    $(this).children("video").get(0).pause();
                                    $(this).children("video").get(0).currentTime = 0;
                                    $(this).children(".post").show();
                                    $(this).children("video").get(0).load();

                                });

                        });
                    </script>
                    <div class="bgover"></div>
                    <div class="newsitmc">
                        <p class="textcenter trendstitle">трансформация общественных институтов</p>
                    </div>
                </a>
                <div class="clearfix"></div>
            </div>
            <p class="content_m190">
                Согласно исследованию <b>McKinsey & Company</b> к 2025 году Тюмень войдёт в число <b>600 ведущих городов планеты</b>, на которых будет приходиться 70% мирового ВВП. Авторы исследования указывают, что современная глобальная экономика — это экономика городов, в которых сегодня проживает половина населения планеты.
            </p>
            <p class="content_m190">
                Основным фактором развития ведущих городов является, по мнению экспертов, рост ВВП на душу населения. Помимо Тюмени, в список попали только четыре российских города: <b>Москва, Санкт-Петербург, Екатеринбург и Красноярск</b>.
            </p>
        </div>
    </div>
    <div class="bgblue">
        <div class="container">
            <p class="t1920 lite content_m90 ttu">В 2030 году в регионе активно развиваются <br>следующие направления</p>
        </div>
    </div>
    <div class="bgcardsv3" style="background: url('/images/2030/bg.jpg') no-repeat; background-position: center bottom; background-size: cover;">
        <div class="container">
            <div class="dadflex">
                <div class="cardv3">
                    <div class="dadflex cardv3content">
                        <div class="cardv3img" style="background: url('/images/2030/6.jpg') no-repeat;"></div>
                        <div class="cardv3text">Цифровые технологии<br> в различных сферах <br>жизни, активный <br>переход бизнеса в цифровую среду</div>
                    </div>
                    <div class="cardv3bg"></div>
                </div>
                <div class="cardv3">
                    <div class="dadflex cardv3content">
                        <div class="cardv3img" style="background: url('/images/2030/7.jpg') no-repeat;"></div>
                        <div class="cardv3text">Возобновляемые источники энергии</div>
                    </div>
                    <div class="cardv3bg"></div>
                </div>
                <div class="cardv3">
                    <div class="dadflex cardv3content">
                        <div class="cardv3img" style="background: url('/images/2030/8.jpg') no-repeat;"></div>
                        <div class="cardv3text">Предоставление персональных социальных услуг каждому человеку на основе обширной цифровой базы человека и общества</div>
                    </div>
                    <div class="cardv3bg"></div>
                </div>
                <div class="cardv3">
                    <div class="dadflex cardv3content">
                        <div class="cardv3img" style="background: url('/images/2030/9.jpg') no-repeat;"></div>
                        <div class="cardv3text">Общественные институты переходят в дополненную и виртуальную реальность</div>
                    </div>
                    <div class="cardv3bg"></div>
                </div>
                <div class="cardv3">
                    <div class="dadflex cardv3content">
                        <div class="cardv3img" style="background: url('/images/2030/10.jpg') no-repeat;"></div>
                        <div class="cardv3text">Создание новых глобальных товаров и услуг</div>
                    </div>
                    <div class="cardv3bg"></div>
                </div>
                <div class="cardv3">
                    <div class="dadflex cardv3content">
                        <div class="cardv3img" style="background: url('/images/2030/11.jpg') no-repeat;"></div>
                        <div class="cardv3text">Киберфизическое производство — объединение материального и виртуального миров в промышленности</div>
                    </div>
                    <div class="cardv3bg"></div>
                </div>
                <div class="cardv3">
                    <div class="dadflex cardv3content">
                        <div class="cardv3img" style="background: url('/images/2030/12.jpg') no-repeat;"></div>
                        <div class="cardv3text">Инновационные технологии: искусственный интеллект, интернет вещей, робототехника, блокчейн</div>
                    </div>
                    <div class="cardv3bg"></div>
                </div>
                <div class="cardv3">
                    <div class="dadflex cardv3content">
                        <div class="cardv3img" style="background: url('/images/2030/13.jpg') no-repeat;"></div>
                        <div class="cardv3text">Новые отрасли экономики, направленные на улучшение экологии</div>
                    </div>
                    <div class="cardv3bg"></div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r121/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanta@0.5.21/dist/vanta.net.min.js"></script>

<script>
    VANTA.NET({
        el: "#particles-js",
        mouseControls: true,
        touchControls: true,
        gyroControls: false,
        minHeight: 200.00,
        minWidth: 200.00,
        scale: 1.00,
        scaleMobile: 1.00,
        color: 0xffffff,
        backgroundColor: 0x000b2f,
        points: 10.00,
        maxDistance: 18.00
    })
</script>


<?$APPLICATION->IncludeComponent(
    "bitrix:slider2",
    "short",
    array(
        "COMPONENT_TEMPLATE" => "short",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "HEROTITLE" => "Тюмень: <span class=\" accent\">РЕГИОН ПЕРВЫХ</span>, 2030",
        "IBLOCK_ID" => "7",
        "IBLOCK_TYPE" => "t2030",
        "PROPERTY_CODE" => ""
    ),
    false
);?>


<section class="bgblue" style="position: relative; overflow: hidden;">
    <div class="container ">
        <div class="t2030contt" style="margin-top:0px;">

            <div class="textsubtitle">Программа инвестиционного <span>развития</span> <br>Тюменской области</div>
            <p>Программа инвестиционного развития Тюменской области до 2024 года была презентована на стратегической сессии 22 января 2020 года. Это совместная работа регионального правительства, бизнеса и экспертов.</p>
            <p><b>Цель новой программы</b>— увеличение потока инвестиций в региональную экономику, выявление точек её роста и развития, формирование предложений по решению вопросов, препятствующих улучшению инвестклимата.</p>
            <p>Создавалась программа в условиях пандемии коронавирусной инфекции, в условиях высокой волатильности и неопределённости. Одна из приоритетных задач региона на ближайшие пять лет — необходимость диверсификации и усиления собственной производственной базы в различных секторах и отраслях экономики региона.</p>
            <p>Среди отраслей с наибольшим инвестиционным потенциалом в регионе выделены направления, в которых сложились условия для кластерного развития или запуска крупных якорных проектов с господдержкой.</p>
            <div class="textsubtitle">Приоритетные направления для привлечения инвестиций на ближайшие годы</div>
            <ul class="ultype2">
                <li>нефтесервисное оборудование и услуги</li>
                <li>нефтехимия и переработка полимеров</li>
                <li>лесопромышленный комплекс</li>
                <li>туризм</li>
                <li>агропромышленный комплекс</li>
                <li>добыча нефти</li>
                <li>поддержка инвестиций на муниципальном уровне</li>
                <li>креативные индустрии</li>
                <li>строительство</li>

            </ul>
            <p>Выделение данных направлений при реализации Программы позволяет сформировать в регионе точки роста инвестиций, которые окажут кумулятивный эффект на смежные отрасли и экономику региона в целом.</p>
        </div>
    </div>
    <div class="t2030bgs"></div>
</section>

<?$APPLICATION->IncludeComponent(
    "bitrix:phototextbtn",
    ".default",
    array(
        "LINK" => "/upload/pres/invest.pdf",
        "LINKTYPE" => "LTF",
        "PIC1" => "/img/t2030h.webp",
        "PIC2" => "/img/t2030q.webp",
        "PIC3" => "/img/t2030v.webp",
        "TEXT" => "Данная презентация содержит полную программу инвестиционного развития Тюменской области",
        "TITLE" => "Инвестиции в тюменскую область",
        "TYPEPHOTO" => "2F1",
        "COMPONENT_TEMPLATE" => ".default",
        "LINKTITLE" => "Скачать программу"
    ),
    false
);?>

<section class="t2030last bgblue">
    <div class="container">
        <div class="content_tab_content content_tab_content_v2">
            <div class="dadflex  personadv bgblue">
                <div class="personadvpic" style="background: url('/images/v2/gp/2/per.jpg') no-repeat; background-size: cover;"></div>
                <div class="personadvtext">
                    <div class="personadvtext_title">Связаться по всем вопросам</div>
                    <div class="personadvcard">
                        <div class="personadvcardcontent">
                            <p class="personadvfio">Смолягин Игорь Владимирович</p>
                            <p class="personadvsubtitle">Заместитель генерального директора – начальник отдела привлечения инвестиционных проектов ИАТО</p>
                            <a href="mailto:smolyagin@obl72.ru" class="personadvemail">smolyagin@obl72.ru</a>
                            <a href="tel:+79196105999" class="personadvphon">+7 919 61-05-999</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
