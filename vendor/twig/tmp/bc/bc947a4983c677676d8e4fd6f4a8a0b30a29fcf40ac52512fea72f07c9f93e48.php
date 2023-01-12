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

/* BlogHome.twig */
class __TwigTemplate_138a15166ea9068628bf77548320cb297aafa77f467dc52a7c67883c5997fe29 extends Template
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
            'script' => [$this, 'block_script'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 2
        return "Layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("Layout.twig", "BlogHome.twig", 2);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 5
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 6
        echo "    <title>Blog - Accueil</title>
";
    }

    // line 9
    public function block_description($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 10
        echo "    <meta name=\"description\" content=\"Bienvenue sur notre blog consacré à l'actualité du cinéma. Parcourez nos articles, critiques et analyses de films \"/>
";
    }

    // line 13
    public function block_script($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 14
        echo "    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css\">
    <script defer src=\"";
        // line 15
        echo twig_escape_filter($this->env, ($context["URL"] ?? null), "html", null, true);
        echo "Public/js/scroll_to_blog.js\"></script>
";
    }

    // line 18
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 19
        echo "
    <header>
        
        <div id=\"header-wrapper\">
        
            ";
        // line 24
        $this->loadTemplate("Nav_bar.twig", "BlogHome.twig", 24)->display($context);
        // line 25
        echo "
            <div class=\"intro_blog\">
                <p>BLOG</p>
                
                <i class=\"fa fa-chevron-down\" id=\"chevron\"></i>
                
            </div>
            
        
        </div>
    </header>

    <section id=\"blog\">

        <form id=\"block_searchbar\" method=\"GET\" action=\"";
        // line 39
        echo twig_escape_filter($this->env, ($context["URL"] ?? null), "html", null, true);
        echo "rechercher\">
        
            <input id=\"searchbar\" class=\"searchbar_movie\" type=\"text\"
            name=\"query\" placeholder=\"Rechercher un film, réalisateur, acteur...\">
            <input type=\"submit\" value=\"rechercher\"/>
        </form>
    

        <div id=\"posts\">
            ";
        // line 48
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["articles"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["article"]) {
            // line 49
            echo "            <article>
                <a href=\"";
            // line 50
            echo twig_escape_filter($this->env, ($context["URL"] ?? null), "html", null, true);
            echo "blog/";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["article"], "slug", [], "any", false, false, false, 50), "html", null, true);
            echo "-";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["article"], "id", [], "any", false, false, false, 50), "html", null, true);
            echo "\">
                    <div class=\"post\">
                        <div class=\"img_bg\" style=\"background-image:url(";
            // line 52
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["article"], "image_article", [], "any", false, false, false, 52), "html", null, true);
            echo ")\"></div>
                    </div>
                    <div class=\"post_infos\">
                        <span>🤵🏻 ";
            // line 55
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["article"], "author", [], "any", false, false, false, 55), "html", null, true);
            echo "</span>
                        <span>🗓️ ";
            // line 56
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["article"], "date_create", [], "any", false, false, false, 56), "d/m/Y"), "html", null, true);
            echo "</span>
                    </div>
                    <h1>";
            // line 58
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["article"], "title", [], "any", false, false, false, 58), "html", null, true);
            echo "</h1>
                    <p>";
            // line 59
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["article"], "description_article", [], "any", false, false, false, 59), "html", null, true);
            echo "</p>
                </a>
            </article>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['article'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 63
        echo "        </div>



        <div id=\"pagination\">

            ";
        // line 69
        if (0 <= twig_compare(($context["current_page"] ?? null), 2)) {
            // line 70
            echo "
                <a href=\"";
            // line 71
            echo twig_escape_filter($this->env, ($context["URL"] ?? null), "html", null, true);
            echo "?page=";
            echo twig_escape_filter($this->env, (($context["current_page"] ?? null) - 1), "html", null, true);
            echo "#blog\"><button class=\"button-blue\">Page précédente</button></a>

            ";
        }
        // line 74
        echo "
            ";
        // line 75
        if (-1 === twig_compare(($context["current_page"] ?? null), ($context["pages_total"] ?? null))) {
            // line 76
            echo "
                <a href=\"";
            // line 77
            echo twig_escape_filter($this->env, ($context["URL"] ?? null), "html", null, true);
            echo "?page=";
            echo twig_escape_filter($this->env, (($context["current_page"] ?? null) + 1), "html", null, true);
            echo "#blog\"><button class=\"button-blue\">Page suivante</button></a>

            ";
        }
        // line 80
        echo "
        </div>


        

    </section>

    

    
";
    }

    public function getTemplateName()
    {
        return "BlogHome.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  203 => 80,  195 => 77,  192 => 76,  190 => 75,  187 => 74,  179 => 71,  176 => 70,  174 => 69,  166 => 63,  156 => 59,  152 => 58,  147 => 56,  143 => 55,  137 => 52,  128 => 50,  125 => 49,  121 => 48,  109 => 39,  93 => 25,  91 => 24,  84 => 19,  80 => 18,  74 => 15,  71 => 14,  67 => 13,  62 => 10,  58 => 9,  53 => 6,  49 => 5,  38 => 2,);
    }

    public function getSourceContext()
    {
        return new Source("", "BlogHome.twig", "C:\\wamp64\\www\\projet-5\\App\\Views\\BlogHome.twig");
    }
}
