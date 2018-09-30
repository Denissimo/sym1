<?php

/* appstable.html.twig */
class __TwigTemplate_36150ad8fb6ecd930ce0c7c4ef578642dc8e3729be18799cfb546d5094a6720f extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", "appstable.html.twig", 1);
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
        echo " ++ ";
        echo twig_escape_filter($this->env, ($context["post"] ?? null), "html", null, true);
        echo " ++ ";
        echo twig_escape_filter($this->env, ($context["login"] ?? null), "html", null, true);
        echo "<br />
            <table class=\"table table-striped\">
                <tr>
                    <td> App.id</td><td> Com.id</td>
                </tr>
            ";
        // line 10
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["comments"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["com"]) {
            // line 11
            echo "                <tr><td>";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["com"], "app", array()), "id", array()));
            echo "</td><td>";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["com"], "id", array()));
            echo "</td></tr>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['com'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo "            </table>

        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "appstable.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  66 => 13,  55 => 11,  51 => 10,  39 => 5,  35 => 3,  32 => 2,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "appstable.html.twig", "F:\\YandexDisk\\OSPanel\\domains\\sym1\\templates\\appstable.html.twig");
    }
}
