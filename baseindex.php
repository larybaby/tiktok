<?php
// linkify_page.php

// Função para adicionar links a palavras específicas em HTML
function addLinkToSpecificWord($html, $targetWord, $link) {
    // Carrega o HTML como um DOMDocument
    $dom = new DOMDocument;
    @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    
    // Cria um XPath para facilitar a navegação e manipulação
    $xpath = new DOMXPath($dom);
    
    // Encontra todos os nós de texto
    $textNodes = $xpath->query('//text()');
    
    foreach ($textNodes as $textNode) {
        $text = $textNode->nodeValue;
        $pattern = '/\b' . preg_quote($targetWord, '/') . '\b/i'; // Regex para a palavra específica
        $replacement = '<a href="' . htmlspecialchars($link, ENT_QUOTES, 'UTF-8') . '" target="_blank">' . htmlspecialchars($targetWord, ENT_QUOTES, 'UTF-8') . '</a>';
        
        // Substitui a palavra alvo por um link, mantendo a formatação original
        $newText = preg_replace($pattern, $replacement, $text);
        
        if ($newText !== $text) {
            // Cria um novo nó de texto com o conteúdo modificado
            $newNode = $dom->createDocumentFragment();
            $newNode->appendXML($newText);
            $textNode->parentNode->replaceChild($newNode, $textNode);
        }
    }
    
    // Retorna o HTML modificado
    return $dom->saveHTML();
}

// URL da página original
$originalPageUrl = 'https://gruposegrupos.com.br/tiktok/2index.html';  // Altere para a URL da página que você deseja reproduzir

// Baixa o conteúdo da página original
$content = file_get_contents($originalPageUrl);

// Define a palavra a ser tornada clicável e o link
$targetWord = 'Baixar o TikTok 18+';  // Palavra que você quer tornar clicável
$link = 'https://gruposegrupos.com.br/tiktok/download';  // URL do link

// Adiciona o link à palavra no conteúdo
$modifiedContent = addLinkToSpecificWord($content, $targetWord, $link);

// Exibe o conteúdo modificado
header('Content-Type: text/html; charset=UTF-8');
echo $modifiedContent;
?>
