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

/* Connection.twig */
class __TwigTemplate_bd2fe119813cc73392190c5bf733f0b2ac36a72ee37e727bbb86053e00f65100 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'description' => [$this, 'block_description'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "Layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("Layout.twig", "Connection.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 5
        echo "    <title>Connection</title>
";
    }

    // line 10
    public function block_description($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 11
        echo "    <meta name=\"description\" content=\"Connectez-vous sur le site du cinéma\"/>
";
    }

    // line 16
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 17
        echo "
    <div class=\"wrapper\">

    ";
        // line 20
        $this->loadTemplate("Nav_bar.twig", "Connection.twig", 20)->display($context);
        echo "   
     
        <div class=\"container\">


            <div class=\"block_form\">
                <h1>Connectez-vous</h1>

                <form action=\"";
        // line 28
        echo twig_escape_filter($this->env, ($context["URL"] ?? null), "html", null, true);
        echo "connection\" method=\"post\">
                    <div class=\"input_form\">
                        <label for=\"email\">Email</label>
                        <input type=\"email\" id=\"email\" name=\"email\" required/>
                    </div>

                    <div class=\"input_form\">
                        <label for=\"password\">Mot de passe</label>
                        <input type=\"password\" id=\"password\" name=\"password\" required/>
                    </div>


                    <div class=\"btn_form_center\">
                        <button type=\"submit\" class=\"button-blue\" name=\"form_submit\">Valider</button>
                    </div>
                
                </form>
                <div>
                    <a href=\"";
        // line 46
        echo twig_escape_filter($this->env, ($context["URL"] ?? null), "html", null, true);
        echo "password_forgot\">Mot de passe oublié</a>
                </div>

               
                ";
        // line 50
        if (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["session"] ?? null), "flash", [], "any", false, false, false, 50), "error_connect", [], "any", false, false, false, 50)) {
            // line 51
            echo "                <p class=\"error message\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["session"] ?? null), "flash", [], "any", false, false, false, 51), "error_connect", [], "any", false, false, false, 51), "html", null, true);
            echo "</p>
                ";
        }
        // line 53
        echo "            </div>
        </div>
    
    </div>


";
    }

    public function getTemplateName()
    {
        return "Connection.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  122 => 53,  116 => 51,  114 => 50,  107 => 46,  86 => 28,  75 => 20,  70 => 17,  66 => 16,  61 => 11,  57 => 10,  52 => 5,  48 => 4,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "Connection.twig", "C:\\wamp64\\www\\projet-5\\App\\Views\\Connection.twig");
    }
}
