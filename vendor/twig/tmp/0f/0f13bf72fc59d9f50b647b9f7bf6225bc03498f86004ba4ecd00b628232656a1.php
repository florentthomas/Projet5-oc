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

/* Layout.twig */
class __TwigTemplate_a491a536bc169c16622088eac8f3b59b2db1cd02472b12f268c1e1114a09e59e extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'description' => [$this, 'block_description'],
            'script' => [$this, 'block_script'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!doctype html>
  <html lang=\"fr\">

    <head>
      <meta charset=\"utf-8\">
      <meta name=\"viewport\" content=\"width=device-width,initial-scale=1\" />
      <link rel=\"apple-touch-icon\" sizes=\"180x180\" href=\"";
        // line 7
        echo twig_escape_filter($this->env, ($context["URL"] ?? null), "html", null, true);
        echo "Public/images/favicon/apple-touch-icon.png\">
      <link rel=\"icon\" type=\"image/png\" sizes=\"32x32\" href=\"";
        // line 8
        echo twig_escape_filter($this->env, ($context["URL"] ?? null), "html", null, true);
        echo "Public/images/favicon/favicon-32x32.png\">
      <link rel=\"icon\" type=\"image/png\" sizes=\"16x16\" href=\"";
        // line 9
        echo twig_escape_filter($this->env, ($context["URL"] ?? null), "html", null, true);
        echo "Public/images/favicon/favicon-16x16.png\">
      <link rel=\"manifest\" href=\"/site.webmanifest\">
      <link rel=\"mask-icon\" href=\"";
        // line 11
        echo twig_escape_filter($this->env, ($context["URL"] ?? null), "html", null, true);
        echo "images/favicon/safari-pinned-tab.svg\" color=\"#5bbad5\">
      <meta name=\"msapplication-TileColor\" content=\"#da532c\">
      <meta name=\"theme-color\" content=\"#ffffff\">

      ";
        // line 15
        $this->displayBlock('title', $context, $blocks);
        // line 17
        echo "      
      ";
        // line 18
        $this->displayBlock('description', $context, $blocks);
        // line 20
        echo "
      <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css\">
      <script defer src=\"https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js\" integrity=\"sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==\" crossorigin=\"anonymous\" referrerpolicy=\"no-referrer\"></script>
      <script defer src=\"";
        // line 23
        echo twig_escape_filter($this->env, ($context["URL"] ?? null), "html", null, true);
        echo "Public/js/navbar_mobile.js\"></script>
      
      ";
        // line 25
        $this->displayBlock('script', $context, $blocks);
        // line 28
        echo "      <link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, ($context["URL"] ?? null), "html", null, true);
        echo "Public/style.css\">
    </head>

    <body>
    
        ";
        // line 33
        $this->displayBlock('content', $context, $blocks);
        // line 38
        echo "
        ";
        // line 39
        $this->loadTemplate("footer.twig", "Layout.twig", 39)->display($context);
        echo "   
        
        
    </body>
  </html>";
    }

    // line 15
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 16
        echo "      ";
    }

    // line 18
    public function block_description($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 19
        echo "      ";
    }

    // line 25
    public function block_script($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 26
        echo "        
      ";
    }

    // line 33
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 34
        echo "          
          
        
        ";
    }

    public function getTemplateName()
    {
        return "Layout.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  140 => 34,  136 => 33,  131 => 26,  127 => 25,  123 => 19,  119 => 18,  115 => 16,  111 => 15,  102 => 39,  99 => 38,  97 => 33,  88 => 28,  86 => 25,  81 => 23,  76 => 20,  74 => 18,  71 => 17,  69 => 15,  62 => 11,  57 => 9,  53 => 8,  49 => 7,  41 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "Layout.twig", "C:\\wamp64\\www\\projet-5\\App\\Views\\Layout.twig");
    }
}
