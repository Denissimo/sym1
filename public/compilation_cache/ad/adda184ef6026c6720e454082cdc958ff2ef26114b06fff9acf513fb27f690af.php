<?php

/* white1.html.twig */
class __TwigTemplate_8c50961dd3c57309abc9147cc25451a3730c2161049db45d9e994bfdce56e00d extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", "white1.html.twig", 1);
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
        echo "    Lucky: ";
        echo twig_escape_filter($this->env, ($context["number"] ?? null), "html", null, true);
        echo "
";
    }

    public function getTemplateName()
    {
        return "white1.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  35 => 3,  32 => 2,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "white1.html.twig", "F:\\YandexDisk\\OSPanel\\domains\\sym1\\templates\\white1.html.twig");
    }
}
