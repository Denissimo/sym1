<?php

/* login.html.twig */
class __TwigTemplate_62d4f381157f220456f9bc128e6347ba3dc3189d2a55bc7362c7fe7483aec937 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", "login.html.twig", 1);
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
        echo "
    <div class=\"row\">
    <div class=\"loginform col-6 offset-3\">
";
        // line 6
        echo twig_escape_filter($this->env, ($context["number"] ?? null), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, ($context["post"] ?? null), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, ($context["login"] ?? null), "html", null, true);
        echo "<br />
        <form class=\"form-horizontal\" role=\"form\" method=\"POST\" action=\"/autorize\">
            <div class=\"form-group\">
                <div class=\"form-group\">
                    <label for=\"inputEmail3\" class=\"col-sm-2 control-label\">Логин</label>
                    <div class=\"col-sm-10\">
                        <input type=\"text\" class=\"form-control\" placeholder=\"email\" name=\"user\" />
                    </div>
                </div>
                <div class=\"form-group\">
                    <label for=\"inputPassword3\" class=\"col-sm-2 control-label\">Пароль</label>
                    <div class=\"col-sm-10\">
                        <input type=\"password\" class=\"form-control\" placeholder=\"Пароль\" name=\"pass\" />
                    </div>
                </div>

                <div class=\"form-group\">
                    <div class=\"col-sm-offset-2 col-sm-10\">
                        <button type=\"submit\" class=\"btn btn-default btn-sm\">Войти</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "login.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  40 => 6,  35 => 3,  32 => 2,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "login.html.twig", "F:\\YandexDisk\\OSPanel\\domains\\sym1\\templates\\login.html.twig");
    }
}
