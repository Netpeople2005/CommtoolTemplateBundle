<?php

namespace Optime\Commtool\TemplateBundle\Twig\TokenParser;

use \Twig_TokenParser;
use \Twig_Token as Token;
use Optime\Commtool\TemplateBundle\Twig\Node\Section as SectionNode;

abstract class AbstractSection extends Twig_TokenParser
{

    protected $options = array();

    public function parse(Token $token)
    {
        $lineNo = $token->getLine();

        $data = $this->getSectionData($this->parser);

        $this->options = $data['options'];

        $node = $this->createNode($token);

        $node->setContent($data['content']);

        return $node;
    }

    protected function createNode(Token $token)
    {
        return new SectionNode($this->options, $token->getLine(), $this->getTag());
    }

    /**
     * Lee las opciones de configuración de la sección.
     * {% section type="singleline" options={id:1} %}
     * 
     * las opciones serian type y options
     * @param \Twig_Parser $parser
     * @return type
     */
    protected function getSectionData(\Twig_Parser $parser)
    {
        $data = array();

        while (!$parser->getStream()->test(Token::BLOCK_END_TYPE)) {
            $name = $parser->getStream()->expect(Token::NAME_TYPE)->getValue();
            $parser->getStream()->expect(Token::OPERATOR_TYPE, '=');
            $value = $parser->getExpressionParser()->parseExpression();
            $data['options'][$name] = $value;
        }

        $parser->getStream()->expect(Token::BLOCK_END_TYPE);
        $data['content'] = $parser->subparse(array($this, 'decideBlockEnd'), true);
        $parser->getStream()->expect(Token::BLOCK_END_TYPE);

        return $data;
    }

    public function decideBlockEnd(Token $token)
    {
        return $token->test(sprintf('end%s', $this->getTag()));
    }

}
