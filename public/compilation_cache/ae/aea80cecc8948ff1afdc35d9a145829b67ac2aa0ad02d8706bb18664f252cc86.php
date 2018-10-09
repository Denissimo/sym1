<?php

/* appstable.html.twig */
class __TwigTemplate_d4cdf72faa837c630e45f2c38e8b2fdeebee1c87970ffe49ff0c5ca7d8cb8298 extends Twig_Template
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
        <div class=\"col-3\">
            <div class=\"card text-center bg-white1\">
                <div class=\"card-header\">
                    Create from
                </div>
                <div class=\"card-body\">
                    <div class=\"col-10\" id=\"datepick_create_from\">
                    </div>
                </div>
                ";
        // line 14
        echo "                ";
        // line 15
        echo "                ";
        // line 16
        echo "            </div>
        </div>
        <div class=\"col-3\">
            <div class=\"card text-center bg-white1\">
                <div class=\"card-header\">
                    Create to
                </div>
                <div class=\"card-body\">
                    <div class=\"col-10\" id=\"datepick_create_to\">
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-3\">
            <div class=\"card text-center bg-white1\">
                <div class=\"card-header\">
                    Update from
                </div>
                <div class=\"card-body\">
                    <div class=\"col-10\" id=\"datepick_update_from\">
                    </div>
                </div>
            </div>
        </div>
        <div class=\"col-3\">
            <div class=\"card text-center bg-white1\">
                <div class=\"card-header\">
                    Update to
                </div>
                <div class=\"card-body\">
                    <div class=\"col-10\" id=\"datepick_update_to\">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=\"container\">
        <div class=\"row mart10\">
            <div class=\"col-12 bg-white1\">
                <p class=\"card-text\">
                <form class=\"form-inline\">
                    <div class=\"form-row col-12 align-items-center\">
                        <div class=\"col-2\">
                            <input type=\"text\" class=\"form-control-sm\" name=\"create_from\" id=\"create_from\"
                                   placeholder=\"create_from\" value=\"";
        // line 62
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["request"] ?? null), "create_from", array()), "html", null, true);
        echo "\">
                        </div>
                        <div class=\"col-2\">
                            <input type=\"text\" class=\"form-control-sm\" name=\"create_to\" id=\"create_to\"
                                   placeholder=\"create_to\" value=\"";
        // line 66
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["request"] ?? null), "create_to", array()), "html", null, true);
        echo "\">
                        </div>
                        <div class=\"col-2\">
                            <input type=\"text\" class=\"form-control-sm\" name=\"update_from\" id=\"update_from\"
                                   placeholder=\"update_from\" value=\"";
        // line 70
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["request"] ?? null), "update_from", array()), "html", null, true);
        echo "\">
                        </div>
                        <div class=\"col-2\">
                            <input type=\"text\" class=\"form-control-sm\" name=\"update_to\" id=\"update_to\"
                                   placeholder=\"update_to\" value=\"";
        // line 74
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["request"] ?? null), "update_to", array()), "html", null, true);
        echo "\">
                        </div>
                        <div class=\"col-2 offset-1\">
                            <button type=\"submit\" class=\"btn btn-sm btn-primary\">Ok</button>
                        </div>
                    </div>
                </form>
                </p>
            </div>
        </div>
    </div>

    <div class=\"row mart10\">
        <div class=\"loginform col-12\">
            <table class=\"table table-striped\">
                <tr>
                    <th> id</th>
                    <th>Пользователь</th>
                    <th>Создано</th>
                    <th>Изменено</th>
                    <th>Комментарии</th>
                    <th>Добавить</th>
                </tr>
                ";
        // line 97
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["apps"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["app"]) {
            // line 98
            echo "                    <tr>
                        <td><a href=\"/app?app_id=";
            // line 99
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["app"], "id", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["app"], "id", array()), "html", null, true);
            echo "</a></td>
                        <td>";
            // line 100
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["app"], "userName", array()), "html", null, true);
            echo "</td>
                        <td>";
            // line 101
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["app"], "createdAtString", array()), "html", null, true);
            echo "</td>
                        <td>";
            // line 102
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["app"], "updatedAtString", array()), "html", null, true);
            echo "</td>
                        <td>
                            ";
            // line 104
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["app"], "comments", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["com"]) {
                // line 105
                echo "                                ";
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
            // line 107
            echo "                        </td>
                        <td>
                            <form method=\"post\" class=\"form-inline\">
                                ";
            // line 111
            echo "                                <input type=\"hidden\" name=\"app_id\" value=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["app"], "id", array()), "html", null, true);
            echo "\">
                                <input type=\"text\" class=\"form-control-sm col-6\" id=\"comfield\" placeholder=\"коммент\">
                                <button type=\"submit\" class=\"btn btn-sm btn-primary\">Ok</button>
                                ";
            // line 115
            echo "                            </form>
                        </td>
                    </tr>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['app'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 119
        echo "            </table>
        </div>
    </div>

    ";
        // line 124
        echo "        ";
        // line 125
        echo "            ";
        // line 126
        echo "            ";
        // line 127
        echo "                ";
        // line 128
        echo "                    ";
        // line 129
        echo "                    ";
        // line 130
        echo "                ";
        // line 131
        echo "                ";
        // line 132
        echo "                ";
        // line 133
        echo "                ";
        // line 134
        echo "            ";
        // line 135
        echo "        ";
        // line 136
        echo "    ";
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
        return array (  240 => 136,  238 => 135,  236 => 134,  234 => 133,  232 => 132,  230 => 131,  228 => 130,  226 => 129,  224 => 128,  222 => 127,  220 => 126,  218 => 125,  216 => 124,  210 => 119,  201 => 115,  194 => 111,  189 => 107,  176 => 105,  172 => 104,  167 => 102,  163 => 101,  159 => 100,  153 => 99,  150 => 98,  146 => 97,  120 => 74,  113 => 70,  106 => 66,  99 => 62,  51 => 16,  49 => 15,  47 => 14,  35 => 3,  32 => 2,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "appstable.html.twig", "E:\\OSPanel\\domains\\sym1\\templates\\appstable.html.twig");
    }
}
