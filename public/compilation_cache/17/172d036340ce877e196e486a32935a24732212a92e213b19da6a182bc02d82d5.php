<?php

/* default.html.twig */
class __TwigTemplate_98ac14a015987f53b410c7d4d26a673562d5380a0b52f404ef22e389e5f734be extends Twig_Template
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
        echo "    <div class=\"row\">
        <div class=\"loginform col-2 offset-5\">
             ";
        // line 5
        echo twig_escape_filter($this->env, ($context["number"] ?? null), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, ($context["post"] ?? null), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, ($context["login"] ?? null), "html", null, true);
        echo "<br />
            <form class=\"form-horizontal\" role=\"form\" method=\"POST\">
                    <div class=\"form-group\">
                        <div class=\"col-sm-offset-2 col-sm-10\">
                            <input type=\"hidden\" name=\"logout\" value=\"1\">
                            <button type=\"submit\" class=\"btn btn-default btn-sm\">Logout</button>
                        </div>
                    </div>
            </form>
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
        return array (  39 => 5,  35 => 3,  32 => 2,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "default.html.twig", "F:\\YandexDisk\\OSPanel\\domains\\sym1\\templates\\default.html.twig");
    }
}
