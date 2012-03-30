<?php
/**

Copyright (C) Szymon Wygnanski (s@finalclass.net)

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
 */
namespace NetCore\ViewCompiler\MetadataTag;
use \NetCore\ViewCompiler\ViewReflection\Variable;
use \NetCore\ViewCompiler\ViewReflection\MetadataTagDefinition;
/**
 * @author: Sel <s@finalclass.net>
 * @date: 30.03.12
 * @time: 14:47
 */
abstract class AbstractMetadataTag
{

	/**
	 * Please implement this method
	 *
	 * @abstract
	 * @return string
	 */
	abstract public function getMetadataTagName();

	/**
	 * The variable this tag is bound to
	 *
	 * @var \NetCore\ViewCompiler\ViewReflection\Variable
	 */
	protected $variable;

	/**
	 * @var \NetCore\ViewCompiler\ViewReflection\MetadataTagDefinition
	 */
	protected $definition;

	public function __construct(Variable $variable, MetadataTagDefinition $definition)
	{
		$this->variable = $variable;
		$this->definition = $definition;
	}

	public function getInterfaces()
	{
		return array();
	}

	// ---------------------
	// GETTER
	// ---------------------

	public function hasGetter()
	{
		return strlen($this->getGetterMethodDefinition()) > 0;
	}

	public function getGetterMethodDefinition()
	{
		return '';
	}

	// -----------------------------------
	// SETTER
	// -----------------------------------

	public function hasSetter()
	{
		return strlen($this->getSetterMethodDefinition()) > 0;
	}

	public function getSetterMethodDefinition()
	{
		return '';
	}

	// ---------------------
	// INITIALIZATION
	// ---------------------

	public function hasInitializationCode()
	{
		return strlen($this->getInitializationCode()) > 0;
	}

	public function getInitializationCode()
	{
		return '';
	}

	// -----------------------------
	// BEFORE RENDER RETRIEVAL CODE
	// -----------------------------

	public function hasBeforeRenderRetrievalCode()
	{
		return strlen($this->getBeforeRenderRetrivalCode()) > 0;
	}

	public function getBeforeRenderRetrivalCode()
	{
		return '';
	}

	// ---------------------
	// PROPERTIES
	// ---------------------

	/**
	 * Override this method for compiler to throw
	 * Exceptions if no parameter is specified
	 *
	 * @return array
	 */
	public function getRequiredProperties()
	{
		return array();
	}

	public function hasDefaultProperty()
	{
		return strlen($this->getDefaultPropertyName()) > 0;
	}

	/**
	 * If you want your tag to have default property name
	 * like that: [Inject("request")] which means: [Inject(property="request")]
	 * then return the property name with this function
	 *
	 * @return string
	 */
	public function getDefaultPropertyName()
	{
		return '';
	}

}
