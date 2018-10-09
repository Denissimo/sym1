<?php

/* base.html.twig */
class __TwigTemplate_dec3158f3cf2ebc31d23169c0bae29338c1db22f5ee3adccf80c1f8e2cbf6c13 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\">
        <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        ";
        // line 6
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 7
        echo "        <link rel=\"stylesheet\" href=\"/js/jquery-ui-1.12.1/jquery-ui.css\">
        <link rel=\"stylesheet\" href=\"/css/bootstrap.css\">
        <link rel=\"stylesheet\" href=\"/css/bootstrap-grid.css\">
        <link rel=\"stylesheet\" href=\"/css/bootstrap-reboot.css\">
        <link rel=\"stylesheet\" href=\"/css/style.css\">
        <script type=\"text/javascript\" src=\"/js/jquery-3.3.1.min.js\"></script>
        <script type=\"text/javascript\" src=\"/js/jquery-ui-1.12.1/jquery-ui.js\"></script>
        <script src=\"js/bootstrap.js\"></script>
        <script src=\"js/bootstrap.bundle.js\"></script>
        <script src=\"js/main.js\"></script>
    </head>
    <body>
    <div class=\"container padt01\">

        <div id=\"carouselExampleIndicators\" class=\"carousel slide\" data-ride=\"carousel\">
            <ol class=\"carousel-indicators\">
                <li data-target=\"#carouselExampleIndicators\" data-slide-to=\"0\" class=\"active\"></li>
                <li data-target=\"#carouselExampleIndicators\" data-slide-to=\"1\"></li>
                <li data-target=\"#carouselExampleIndicators\" data-slide-to=\"2\"></li>
            </ol>
            <div class=\"carousel-inner\">
                <div class=\"carousel-item active\">
                    <img class=\"d-block w-100\" src=\"/images/old-01.jpg\" alt=\"First slide\">
                    <div class=\"carousel-caption d-none d-md-block\">
                        <h3>ZZZZ</h3>
                        <p>по zxzczxcz</p>
                    </div>
                </div>
                <div class=\"carousel-item\">
                    <img class=\"d-block w-100\" src=\"/images/old-03.jpg\" alt=\"Second slide\">
                    <div class=\"carousel-caption d-none d-md-block\">
                        <h3>Индивилуальный подход</h3>
                        <p>Мы практикуем комплексный и при этом — индивидуальный подход к каждому обратившемуся человеку.</p>
                    </div>
                </div>
                <div class=\"carousel-item\">
                    <img class=\"d-block w-100\" src=\"/images/old-02.jpg\" alt=\"Third slide\">
                    <div class=\"carousel-caption d-none d-md-block\">
                        <h3>ZZZZZZ</h3>
                        <p>Большой опыт работы</p>
                    </div>
                </div>
            </div>
            <a class=\"carousel-control-prev\" href=\"#carouselExampleIndicators\" role=\"button\" data-slide=\"prev\">
                <span class=\"carousel-control-prev-icon\" aria-hidden=\"true\"></span>
                <span class=\"sr-only\">Previous</span>
            </a>
            <a class=\"carousel-control-next\" href=\"#carouselExampleIndicators\" role=\"button\" data-slide=\"next\">
                <span class=\"carousel-control-next-icon\" aria-hidden=\"true\"></span>
                <span class=\"sr-only\">Next</span>
            </a>
        </div>


        <nav class=\"navbar navbar-expand-lg navbar-light grad1 rounded d-flex flex-row\">
            <a class=\"navbar-brand align-self-center\" href=\"/\">ZZZZZZ</a>
            <button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
                <span class=\"navbar-toggler-icon\"></span>
            </button>

            <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
                <ul class=\"navbar-nav mr-auto\">
                    <li class=\"nav-item active\">
                        <a class=\"nav-link\" href=\"#\">О нас <span class=\"sr-only\">(current)</span></a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"apps/\">Заявки</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"#\">Контакты</a>
                    </li>
                    <li class=\"nav-item dropdown\">
                        <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                            Dropdown
                        </a>
                        <div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">
                            <a class=\"dropdown-item\" href=\"#\">Action</a>
                            <a class=\"dropdown-item\" href=\"#\">Another action</a>
                            <div class=\"dropdown-divider\"></div>
                            <a class=\"dropdown-item\" href=\"#\">Something else here</a>
                        </div>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link disabled\" href=\"#\">Disabled</a>
                    </li>
                </ul>
            ";
        // line 93
        if (($context["logged"] ?? null)) {
            // line 94
            echo "                <form class=\"form-horizontal\" role=\"form\" method=\"POST\" action=\"/autorize\">
                            <input type=\"hidden\" name=\"logout\" value=\"1\">
                            <button type=\"submit\" class=\"btn btn-default btn-sm\">Logout</button>
                </form>
            ";
        }
        // line 99
        echo "            </div>
        </nav>




    </div>



    <div class=\"container\">


        ";
        // line 112
        $this->displayBlock('body', $context, $blocks);
        // line 113
        echo "        ";
        $this->displayBlock('javascripts', $context, $blocks);
        // line 114
        echo "
        <div class=\"row\">
            <div class=\"col\">
                <div class=\"col-12 footer grad1 mart10 padt00\">
                    &nbsp;2018
                </div>
            </div>
        </div>
    </div>
    </body>
</html>
";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo "Welcome!";
    }

    // line 6
    public function block_stylesheets($context, array $blocks = array())
    {
    }

    // line 112
    public function block_body($context, array $blocks = array())
    {
    }

    // line 113
    public function block_javascripts($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  187 => 113,  182 => 112,  177 => 6,  171 => 5,  156 => 114,  153 => 113,  151 => 112,  136 => 99,  129 => 94,  127 => 93,  39 => 7,  37 => 6,  33 => 5,  27 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "base.html.twig", "E:\\OSPanel\\domains\\sym1\\templates\\base.html.twig");
    }
}
