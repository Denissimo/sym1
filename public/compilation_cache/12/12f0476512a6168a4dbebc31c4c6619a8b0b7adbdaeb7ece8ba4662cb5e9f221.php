<?php

/* application.html.twig */
class __TwigTemplate_4aaca3b533722155d9637b6ed24f0137fbed0a65f46dbe785b79c5979f3be9b9 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", "application.html.twig", 1);
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
        <div class=\"col-12\">

            <a href=\"/apps\"><button class=\"btn btn-warning\">Список заявок</button></a>
            <table class=\"table table-striped\">
                <tr><th>Параметр</th><th>Значение</th></tr>
                <tr><td>ID</td><td>";
        // line 9
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "id", array()), "html", null, true);
        echo "</td></tr>
                <tr><td>Создан</td><td>";
        // line 10
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "createdAtString", array()), "html", null, true);
        echo "</td></tr>
                <tr><td>Изменён</td><td>";
        // line 11
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "updatedAtString", array()), "html", null, true);
        echo "</td></tr>
                <tr><td>Пользователь</td><td>";
        // line 12
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "user", array()), "name", array()), "html", null, true);
        echo "</td></tr>
                <tr><td>Емайл</td><td><a href=\"mailto:";
        // line 13
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "user", array()), "email", array()), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "user", array()), "email", array()), "html", null, true);
        echo "</a></td></tr>
                <tr><td>Комментарии</td><td>
                        ";
        // line 15
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "comments", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["com"]) {
            // line 16
            echo "                            ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["com"], "id", array()), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["com"], "tsString", array()), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["com"], "comment", array()), "html", null, true);
            echo "  <br/>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['com'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 18
        echo "                    </td></tr>
            </table>
            Дальше тут будут данные заёмщика (FieldValues)
        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "application.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  83 => 18,  70 => 16,  66 => 15,  59 => 13,  55 => 12,  51 => 11,  47 => 10,  43 => 9,  35 => 3,  32 => 2,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "application.html.twig", "E:\\OSPanel\\domains\\sym1\\templates\\application.html.twig");
    }
}
