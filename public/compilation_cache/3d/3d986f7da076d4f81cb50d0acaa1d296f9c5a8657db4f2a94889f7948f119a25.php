<?php

/* default.html.twig */
class __TwigTemplate_9751bbac300d08a08a5adc202e8c5bea8cbcedb4af3ad2701b3ccc5f4d7f1d82 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", "default.html.twig", 1);
        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_body($context, array $blocks = array())
    {
        // line 3
        echo "    <div class=\"row padt01\">
        <div class=\"loginform col-2 offset-5\">

            <a href=\"/apps\"><button class=\"btn btn-warning\">Список заявок</button></a>
             ";
        // line 8
        echo "            <!--
            <form class=\"form-horizontal\" role=\"form\" method=\"POST\" action=\"/autorize\">
                    <div class=\"form-group\">
                        <div class=\"col-sm-offset-2 col-sm-10\">
                            <input type=\"hidden\" name=\"logout\" value=\"1\">
                            <button type=\"submit\" class=\"btn btn-default btn-sm\">Logout</button>
                        </div>
                    </div>
            </form>
            -->
        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "default.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  41 => 8,  35 => 3,  32 => 2,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "default.html.twig", "E:\\OSPanel\\domains\\sym1\\templates\\default.html.twig");
    }
}
