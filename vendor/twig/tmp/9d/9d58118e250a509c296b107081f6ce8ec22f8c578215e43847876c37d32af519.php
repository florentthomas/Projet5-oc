<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* Nav_bar.twig */
class __TwigTemplate_dc945cac88cb472c230f0f79950ed312af1701284dffa67955051b19b708dfd5 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "
    <nav class=\"nav_bar\">
        <a href=\"";
        // line 3
        echo twig_escape_filter($this->env, ($context["URL"] ?? null), "html", null, true);
        echo "\" class=\"link_blog\"><img src=\"";
        echo twig_escape_filter($this->env, ($context["URL_IMG"] ?? null), "html", null, true);
        echo "logo.png\" class=\"logo\" alt=\"logo\"/></a>

        
       

        <ul class=\"menu_navbar_large_screen menu_navbar menu_hide\">
            ";
        // line 9
        if (twig_get_attribute($this->env, $this->source, ($context["session"] ?? null), "user", [], "any", false, false, false, 9)) {
            // line 10
            echo "
            <li><a href=\"";
            // line 11
            echo twig_escape_filter($this->env, ($context["URL"] ?? null), "html", null, true);
            echo "setting\"><img src=\"";
            echo twig_escape_filter($this->env, ($context["URL_IMG_AVATARS"] ?? null), "html", null, true);
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["session"] ?? null), "user", [], "any", false, false, false, 11), "photo", [], "any", false, false, false, 11), "html", null, true);
            echo "\" alt=\"photo de profil\" class=\"photo_profil\" id=\"photo_navbar\"/>";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["session"] ?? null), "user", [], "any", false, false, false, 11), "pseudo", [], "any", false, false, false, 11), "html", null, true);
            echo "</a></li>

                ";
            // line 13
            if (0 !== twig_compare(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["session"] ?? null), "user", [], "any", false, false, false, 13), "type_user", [], "any", false, false, false, 13), "user")) {
                // line 14
                echo "                    <li><a href=\"";
                echo twig_escape_filter($this->env, ($context["URL"] ?? null), "html", null, true);
                echo "admin_blog/modifier_article\"><i class=\"fa fa-cog\" aria-hidden=\"true\"></i> Gérer le blog</a></li>
                ";
            }
            // line 16
            echo "            
            <li><a href=\"";
            // line 17
            echo twig_escape_filter($this->env, ($context["URL"] ?? null), "html", null, true);
            echo "disconnect\"><i class=\"fa-solid fa-circle-xmark\"></i> SE DECONNECTER</a></li>
            ";
        }
        // line 19
        echo "
            ";
        // line 20
        if ( !twig_get_attribute($this->env, $this->source, ($context["session"] ?? null), "user", [], "any", false, false, false, 20)) {
            // line 21
            echo "            <li><a href=\"";
            echo twig_escape_filter($this->env, ($context["URL"] ?? null), "html", null, true);
            echo "inscription\"><i class=\"fa-solid fa-user-plus\"></i> S'INSCRIRE</a></li>
            <li><a href=\"";
            // line 22
            echo twig_escape_filter($this->env, ($context["URL"] ?? null), "html", null, true);
            echo "login\"><i class=\"fa-solid fa-user\"></i> SE CONNECTER</a></li>
            ";
        }
        // line 24
        echo "
            
        </ul>

        <span id=\"menu_mobile_navbar\"><i class=\"fa fa-bars\" aria-hidden=\"true\"></i></span>


    </nav>
";
    }

    public function getTemplateName()
    {
        return "Nav_bar.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  98 => 24,  93 => 22,  88 => 21,  86 => 20,  83 => 19,  78 => 17,  75 => 16,  69 => 14,  67 => 13,  57 => 11,  54 => 10,  52 => 9,  41 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "Nav_bar.twig", "C:\\wamp64\\www\\projet-5\\App\\Views\\Nav_bar.twig");
    }
}
