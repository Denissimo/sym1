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
        echo "    <div class=\"row mart10\">
        <div class=\"col-12\">
            <div class=\"card text-center bg-white1\">
                <div class=\"card-header\">
                    Фильтр
                </div>
                <div class=\"card-body\">

                    <p class=\"card-text\">
                         Начало подробной информации. Начало подробной информации. Начало подробной информации. Начало подробной информации
                        <form class=\"form-inline\">
                            ";
        // line 15
        echo "                            <input type=\"text\" class=\"form-control-sm col-2\" name=\"create_from\" placeholder=\"create_from\" value=\"";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["request"] ?? null), "create_from", array()), "html", null, true);
        echo "\">
                            <button type=\"submit\" class=\"btn btn-sm btn-primary\">Ok</button>
                            ";
        // line 18
        echo "                        </form>
                    </p>

                </div>
                ";
        // line 23
        echo "                    ";
        // line 24
        echo "                ";
        // line 25
        echo "            </div>
        </div>
    </div>
    <div class=\"row mart10\">
        <div class=\"loginform col-12\">
            <table class=\"table table-striped\">
                <tr>
                    <th> id</th><th>Создано</th><th>Изменено</th><th>Комментарии</th><th>Добавить</th>
                </tr>
                ";
        // line 34
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["apps"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["app"]) {
            // line 35
            echo "                <tr>
                    <td>";
            // line 36
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["app"], "id", array()), "html", null, true);
            echo "</td>
                    <td>";
            // line 37
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["app"], "createdAtString", array()), "html", null, true);
            echo "</td>
                    <td>";
            // line 38
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["app"], "updatedAtString", array()), "html", null, true);
            echo "</td>
                    <td>
                        ";
            // line 40
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["app"], "comments", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["com"]) {
                // line 41
                echo "                        ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["com"], "id", array()), "html", null, true);
                echo " ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["com"], "tsString", array()), "html", null, true);
                echo " ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["com"], "comment", array()), "html", null, true);
                echo "  <br />
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['com'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 43
            echo "                    </td>
                    <td>
                        <form method=\"post\" class=\"form-inline\">
                            ";
            // line 47
            echo "                            <input type=\"hidden\" name=\"app_id\" value=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["app"], "id", array()), "html", null, true);
            echo "\">
                            <input type=\"text\" class=\"form-control-sm col-6\" id=\"comfield\" placeholder=\"коммент\">
                            <button type=\"submit\" class=\"btn btn-sm btn-primary\">Ok</button>
                            ";
            // line 51
            echo "                        </form>
                    </td>
                </tr>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['app'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 55
        echo "            </table>
        </div>
    </div>

    <div class=\"row\">
        <div class=\"loginform col-2 offset-5\">
             ";
        // line 61
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
        // line 67
        echo "                ";
        // line 68
        echo "            ";
        // line 69
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
        return array (  157 => 69,  155 => 68,  153 => 67,  141 => 61,  133 => 55,  124 => 51,  117 => 47,  112 => 43,  99 => 41,  95 => 40,  90 => 38,  86 => 37,  82 => 36,  79 => 35,  75 => 34,  64 => 25,  62 => 24,  60 => 23,  54 => 18,  48 => 15,  35 => 3,  32 => 2,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "appstable.html.twig", "F:\\YandexDisk\\OSPanel\\domains\\sym1\\templates\\appstable.html.twig");
    }
}
