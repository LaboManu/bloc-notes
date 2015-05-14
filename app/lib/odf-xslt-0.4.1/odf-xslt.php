<?php

/**
 * ofd-xslt is a templating engine that uses ODF documents as a basis for XSLT templates.
 * See the README for documentation and an example.
 *
 * @copyright Copyright (c) 2007, Tribal Internet Marketing B.V.
 * @author Sander Marechal <s.marechal@jejik.com>
 * @license http://www.gnu.org/licenses/ The GNU General Public License version 3 or later
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package PHP-ODF-XSLT
 */

/**
 * Holds an ODF-XSLT sylesheet and allows mutiple transformations to ODF using different XML documents
 *
 * To use it, simply instanciate it, load it with a stylesheet (either an ODF zipfile containing
 * XSLT stylesheets or an ODF document with ODF-XSLT markup) and call one of the
 * transform_to_* functions with the XML data.
 *
 * @package PHP-ODF-XSLT
 */
class ODFXSLTProcessor
{
	/** @var string The location to store temporary files */
	public $temp_dir = '/tmp/';
	
	/** @var string The location to store preprocessed ODF files */
	public $cache_dir = '/var/cache/odf-xslt/';
	
	/** @var string The location of the ODF template files */
	public $template_dir = '/';
	
	/** @var array An array of filenames inside the ODF document that must be processed. */
	public $container_files = array('styles.xml', 'content.xml');
	
	/** @var bool If this is true, the cache will alwyas be regenerated */
	public $cache_force_update = false;
	
	/** @var array A list of all namespace URIs */
	public $xmlns = array();
	
	/** @var array The meta data of the loaded stylesheet */
	public $meta = array();
	
	/**
	 * @var string The meta:generator string to be used. Classes that derive from ODFXSLTProcessor
	 * should change this variable.
	 */
	protected $generator = 'ODF-XSLT/0.4.1';
	
	/**
	 * @var array An array of preprocessors in the format
	 * array('function' => $function, 'user_data' => &$user_data)
	 */
	protected $preprocessors = array();
	
	/**
	 * @var array An array of postprocessors in the format
	 * array('function' => $function, 'user_data' => &$user_data)
	 */
	protected $postprocessors = array();
	
	/**
	 * @var array An array of XSLTProcessor objects. One XSLTProcessor for every
	 * $container_files after a stylesheet has been loaded and preprocessed.
	 */
	private $cache_files;
	
	/** @var string The name of the currently loaded stylesheet */
	private $stylesheet;
	
	/**
	 * Create and set up the initial ODFXSLTProcessor object
	 */
	public function __construct()
	{
		$this->xmlns['office'] = "urn:oasis:names:tc:opendocument:xmlns:office:1.0";
		$this->xmlns['style'] = "urn:oasis:names:tc:opendocument:xmlns:style:1.0";
		$this->xmlns['text'] = "urn:oasis:names:tc:opendocument:xmlns:text:1.0";
		$this->xmlns['table'] = "urn:oasis:names:tc:opendocument:xmlns:table:1.0";
		$this->xmlns['draw'] = "urn:oasis:names:tc:opendocument:xmlns:drawing:1.0";
		$this->xmlns['fo'] = "urn:oasis:names:tc:opendocument:xmlns:xsl-fo-compatible:1.0";
		$this->xmlns['xlink'] = "http://www.w3.org/1999/xlink";
		$this->xmlns['dc'] = "http://purl.org/dc/elements/1.1/";
		$this->xmlns['meta'] = "urn:oasis:names:tc:opendocument:xmlns:meta:1.0";
		$this->xmlns['number'] = "urn:oasis:names:tc:opendocument:xmlns:datastyle:1.0";
		$this->xmlns['svg'] = "urn:oasis:names:tc:opendocument:xmlns:svg-compatible:1.0";
		$this->xmlns['chart'] = "urn:oasis:names:tc:opendocument:xmlns:chart:1.0";
		$this->xmlns['dr3d'] = "urn:oasis:names:tc:opendocument:xmlns:dr3d:1.0";
		$this->xmlns['math'] = "http://www.w3.org/1998/Math/MathML";
		$this->xmlns['form'] = "urn:oasis:names:tc:opendocument:xmlns:form:1.0";
		$this->xmlns['script'] = "urn:oasis:names:tc:opendocument:xmlns:script:1.0";
		$this->xmlns['ooo'] = "http://openoffice.org/2004/office";
		$this->xmlns['ooow'] = "http://openoffice.org/2004/writer";
		$this->xmlns['oooc'] = "http://openoffice.org/2004/calc";
		$this->xmlns['dom'] = "http://www.w3.org/2001/xml-events";
		$this->xmlns['xforms'] = "http://www.w3.org/2002/xforms";
		$this->xmlns['xsd'] = "http://www.w3.org/2001/XMLSchema";
		$this->xmlns['xsi'] = "http://www.w3.org/2001/XMLSchema-instance";
		$this->xmlns['xslt'] = "http://www.w3.org/1999/XSL/Transform";
		$this->xmlns['manifest'] = "urn:oasis:names:tc:opendocument:xmlns:manifest:1.0";
		
		$this->meta['dc:title'] = '';
		$this->meta['dc:description'] = '';
		$this->meta['dc:subject'] = '';
		$this->meta['dc:creator'] = '';
		$this->meta['dc:date'] = '';
		$this->meta['dc:language'] = '';
		$this->meta['meta:generator'] = '';
		$this->meta['meta:keyword'] = '';
		$this->meta['meta:initial-creator'] = '';
		$this->meta['meta:printed-by'] = '';
		$this->meta['meta:creation-date'] = '';
		$this->meta['meta:print-date'] = '';
		$this->meta['meta:date'] = '';
		$this->meta['meta:editing-cycles'] = '';
		$this->meta['meta:editing-duration'] = '';
	}
	
	/**
	 * Register a preprocessor with the template engine. Preprocessor are in the form of
	 * function($source, &$ODFXSLTProcessor, &$user_data) and are executed in the order they are
	 * registered. They are called after a document has been loaded from the cache but before
	 * XSLT processing. Throws an exception on failure.
	 *
	 * @param mixed $function A function in a format that is callable by PHP's call_user_func()
	 * @param mixed &$user_data An arbitraty variable that will be passed back to the preprocessor
	 * @return void
	 */
	public function register_preprocessor($function, &$user_data = null)
	{
		if (!is_callable($function))
		{
			if (is_array($function))
				$function = implode('::', $function);
			throw new Exception("Function '$function' is not defined.");
		}
		
		$this->preprocessors[] = array('function' => $function, 'user_data' => &$user_data);
	}
	
	/**
	 * Register a postprocessor with the template engine. Postprocessor are in the form of
	 * function($source, &$ODFXSLTProcessor, &$user_data) and are executed in the order they 
	 * are registered. They are called after a document has been processed by the XSLT processor 
	 * but before the result is saved or returned. Throws an exception on failure.
	 *
	 * @param mixed $function A function in a format that is callable by PHP's call_user_func()
	 * @param mixed &$user_data An arbitraty variable that will be passed back to the postprocessor
	 * @return void
	 */
	public function register_postprocessor($function, &$user_data = null)
	{
		if (!is_callable($function))
		{
			if (is_array($function))
				$function = implode('::', $function);
			throw new Exception("Function '$function' is not defined.");
		}
		
		$this->postprocessors[] = array('function' => $function, 'user_data' => &$user_data);
	}
	
	/**
	 * Import the $container_files from $stylesheet and run them through the preprocessors.
	 *
	 * @param string $stylesheet Path to a stylesheet
	 * @return void
	 */
	public function import_stylesheet($stylesheet)
	{
		// Update the cache if required
		$this->stylesheet = $stylesheet;
		$this->cache_update($stylesheet);
		
		// Open the ODF container
		$zip = new Ziparchive();
		$zip->open($this->cache_get_filename($stylesheet));
		
		// Load the metadata
		$this->load_meta($zip);
		
		// Grab the manifest. Needed for image replacement
		$manifest = new DOMDocument();
		$manifest->loadXML($zip->getFromName('META-INF/manifest.xml'));
		
		// Loop through all the container files and cache them
		foreach ($this->container_files as $file)
		{
			$contents = $zip->getFromName($file);
			foreach ($this->preprocessors as $preprocessor)
				$contents = call_user_func($preprocessor['function'], $contents, $this, $preprocessor['user_data']);
			$dom = new DOMDocument();
			$dom->loadXML($contents);
			$this->remove_images($dom, $manifest, $zip);
			$this->cache_files[$file] = new XSLTProcessor();
			$this->cache_files[$file]->importStyleSheet($dom);
		}
		
		$zip->deleteName('META-INF/manifest.xml');
		$zip->addFromString('META-INF/manifest.xml', $manifest->saveXML());
		$zip->close();
	}
	
	/**
	 * Process the ODF template with the data and return the resulting ODF
	 *
	 * @param object $data A DOMDocument containing the data for the stylesheets
	 * @return string The contents of the resulting ODF file
	 */
	public function transform_to_memory($data)
	{
		$temp_filename = tempnam($this->temp_dir, 'ODFXSLT_');
		$this->transform_to_file($data, $temp_filename);
		$contents = file_get_contents($temp_filename);
		unlink($temp_filename);
		return $contents;
	}
	
	/**
	 * Process an ODF template with the data and save the result to $destination
	 *
	 * @param object $data A DOMDocument containing the data for the stylesheets
	 * @return void
	 */
	public function transform_to_file($data, $destination)
	{
		// Copy the cache to the destination
		copy($this->cache_get_filename($this->stylesheet), $destination);
		
		// Open the ODF container
		$zip = new Ziparchive();
		$zip->open($destination);
		
		// Grab the manifest. Needed for image replacement
		$manifest = new DOMDocument();
		$manifest->loadXML($zip->getFromName('META-INF/manifest.xml'));
		
		// Loop through all the stylesheets and process them
		foreach ($this->cache_files as $file => $stylesheet)
		{
			$zip->deleteName($file);
			
			$dom = $stylesheet->transformToDOC($data);
			$this->add_images($dom, $manifest, $zip);
			$contents = $dom->saveXML();
			
			foreach ($this->postprocessors as $postprocessor)
				$contents = call_user_func($postprocessor['function'], $contents, $this, $postprocessor['user_data']);
			$zip->addFromString($file, $contents);
		}
		
		$zip->deleteName('META-INF/manifest.xml');
		$zip->addFromString('META-INF/manifest.xml', $manifest->saveXML());
		
		// Update the metadata
		$this->meta['meta:generator'] = $this->generator . ' ' . $this->meta['meta:generator'];
		$this->meta['dc:creator'] = $this->generator;
		$this->meta['dc:date'] = date('Y-m-d\TH:i:s');
		$this->save_meta($zip);
		
		// All done!
		$zip->close();
	}
	
	/**
	 * Clear the cache file associated with the stylesheet
	 *
	 * @return void
	 */
	public function cache_clear()
	{
		unlink($this->cache_get_filename($this->stylesheet));
	}
	
	/**
	 * Load the metadata from meta.xml into $this->meta. If there are multiple entries
	 * of the same element, the last one is used. See the constructor for a list of meta
	 * elements that is loaded.
	 *
	 * @param resource &$zip A valid Zipfile handle to the ODF container
	 * @return void
	 */
	protected function load_meta(&$zip)
	{
		$dom = new DOMDocument();
		$dom->loadXML($zip->getFromName('meta.xml'));
		
		foreach ($this->meta as $tag => $value)
		{
			list($namespace, $element) = explode(':', $tag);
			$nodeList = $dom->getElementsByTagNameNS($this->xmlns[$namespace], $element);
			foreach ($nodeList as $node)
				$this->meta[$tag] = $node->nodeValue;
		}
	}
	
	/**
	 * Update meta.xml with the values from $this->meta. Note that if meta.xml contains duplicate elements
	 * this function will remove them all and replace them with a single value as specified by $this->meta.
	 * See the constructor for teh list of affected meta elements.
	 *
	 * @param resource &$zip A valid Zipfile handle to the ODF container
	 * @return void
	 */
	protected function save_meta(&$zip)
	{
		$dom = new DOMDocument();
		$dom->loadXML($zip->getFromName('meta.xml'));
		
		foreach ($this->meta as $tag => $value)
		{
			if ($value)
			{
				list($namespace, $element) = explode(':', $tag);
				$nodeList = $dom->getElementsByTagNameNS($this->xmlns[$namespace], $element);
				foreach ($nodeList as $node)
					$node->parentNode->removeChild($node);
				
				$meta = $dom->getElementsByTagNameNS($this->xmlns['office'], 'meta')->item(0);
				$node = $dom->createElementNS($this->xmlns[$namespace], $element, $value);
				$meta->appendChild($node);
			}
		}
		
		$zip->deleteName('meta.xml');
		$zip->addFromString('meta.xml', $dom->saveXML());
	}
	
	/**
	 * Loop through the ODF document adding the replaced images
	 *
	 * @param object &$dom A DOMDocument object for the file which was parsed
	 * @param object &$manifest A DOMDocument containing the manifest.xml
	 * @param resource &$zip A valid Zipfile handle to the ODF container
	 * @return void
	 */
	protected function add_images(&$dom, &$manifest, &$zip)
	{
		// XPath object for the file we're parsing
		$xpath = new DOMXPath($dom);
		foreach ($this->xmlns as $prefix => $uri)
			$xpath->registerNamespace($prefix, $uri);
		
		// XPath object for the manifest
		$manifest_xpath = new DOMXPath($manifest);
		$manifest_xpath->registerNamespace('manifest', $this->xmlns['manifest']);
		
		// Loop through all the images
		$nodeList = $xpath->query('//draw:image/@xlink:href');
		foreach ($nodeList as $node)
		{
			$image_path = $node->nodeValue;
			$matchList = $manifest_xpath->query("//manifest:file-entry/@manifest:full-path[. = '$image_path']");
			$match = $matchList->item(0);
			
			// Not in the manifest? Add the image to the ODF container
			if ($match === null)
			{
				// Add the file
				$extension = strrchr($image_path, '.');
				$filename = 'Pictures/' . md5(uniqid()) . $extension;
				$zip->addFile($this->expand_filename($image_path), $filename);
				
				// Update the manifest
				$element = $manifest->createElementNS($this->xmlns['manifest'], 'manifest:file-entry');
				$element->setAttributeNS($this->xmlns['manifest'], 'manifest:media-type', shell_exec("file -i -b " . $this->expand_filename($image_path)));
				$element->setAttributeNS($this->xmlns['manifest'], 'manifest:full-path', $filename);
				$manifest->documentElement->appendChild($element);
				
				// Set the right xlink:href
				$node->nodeValue = $filename;
			}
		}
	}
	
	/**
	 * Step through all draw:image elements and remove the image from the ODF container if there is an XSLT
	 * directive in it that replaces the image
	 *
	 * @param object &$dom A DOMDocument object for the file which was parsed
	 * @param object &$manifest A DOMDocument containing the manifest.xml
	 * @param resource &$zip A valid Zipfile handle to the ODF container
	 * @return void
	 */
	protected function remove_images(&$dom, &$manifest, &$zip)
	{
		// Load the manifest
		$manifest = new DOMDocument();
		$manifest->loadXML($zip->getFromName('META-INF/manifest.xml'));
		
		// XPath object for the file we're parsing
		$xpath = new DOMXPath($dom);
		foreach ($this->xmlns as $prefix => $uri)
			$xpath->registerNamespace($prefix, $uri);
		
		// XPath object for the manifest
		$manifest_xpath = new DOMXPath($manifest);
		$manifest_xpath->registerNamespace('manifest', $this->xmlns['manifest']);
		
		// Select all draw:image xlink:href's that are going to be replaced
		$nodeList = $xpath->query("//draw:image/@xlink:href[../xslt:attribute/@name='xlink:href']");
		foreach ($nodeList as $node)
		{
			$image_path = $node->nodeValue;
			
			// Remove the image
			$zip->deleteName($image_path);
			
			// Remove the image from the manifest
			$matchList = $manifest_xpath->query("//manifest:file-entry[@manifest:full-path = '$image_path']");
			
			// Multiple image can reference the same manifest source image, so the image may have been
			// removed already. That's why this check needs to be here.
			if ($matchList->length == 1)
			{
				$match = $matchList->item(0);
				$match->parentNode->removeChild($match);
			}
			// Remove the xlink:href attribute
			$node->parentNode->removeAttributeNS($this->xmlns['xlink'], 'xlink:href');
		}
		
	}
	
	/**
	 * Expand a template name to a full, absolute path if it's not already an absolute path
	 *
	 * @param string $filename The path to expand
	 * @return string An absolute path
	 */
	protected function expand_filename($filename)
	{
		if ($filename{0} != '/')
			$filename = $this->template_dir . $filename;
		
		return $filename;
	}
	
	/**
	 * Return a full path to the cache file belonging to $template_name
	 *
	 * @param string $template_name The name of the template file to find the cache path for
	 * @return string A path to the cache file
	 */
	protected function cache_get_filename($template_name)
	{
		$template_name = $this->expand_filename($template_name);
		return $this->cache_dir . str_replace(array('/', '.'), array('_', '_'), $template_name) . '_' . md5(serialize($this->container_files));
	}
	
	/**
	 * Generate a new cache for $template_name. This function also converts the $container_files
	 * from marked-up ODF to XSLT if it's not XSLT already.
	 *
	 * @param string $template_name Path to a template to create a cache for
	 * @return void
	 */
	protected function cache_update($template_name)
	{
		$cache_filename = $this->cache_get_filename($template_name);
		$template_name = $this->expand_filename($template_name);
		
		if (file_exists($cache_filename)
			&& (filemtime($template_name) <= filemtime($cache_filename))
			&& (filectime($template_name) <= filectime($cache_filename))
			&& $this->cache_force_update == false)
			return;
		
		copy($template_name, $cache_filename);
		
		$zip = new Ziparchive();
		$zip->open($cache_filename);
		
		foreach ($this->container_files as $file)
		{
			$contents = $zip->getFromName($file);
			$dom = new DOMDocument();
			$dom->loadXML($contents);
			
			if ($dom->documentElement->nodeName != 'stylesheet' || $dom->documentElement->namespaceURI != $this->xmlns['xslt'])
			{
				$zip->deleteName($file);
				$zip->addFromString($file, $this->convert_to_xslt($contents));
			}	
		}
		
		$zip->close();
	}
	
	/**
	 * Convert an ODF XML file to XSLT according to the ODF-XSLT markup (see documentation). Takes the XML
	 * as string and returns the XSLT as string
	 *
	 * @param string $contents A single ODF XML file as text
	 * @return string An XSLT document as text
	 */
	protected function convert_to_xslt($contents)
	{
		$tokens = array();
		$dom = new DOMDocument();
		$dom->loadXML($contents);
		
		// First, wrap up the ODF in XSLT stylesheet and template tags tags
		$stylesheet = $dom->createElementNS($this->xmlns['xslt'], 'xslt:stylesheet');
		$stylesheet->setAttribute('version', '1.0');
		
		$template = $dom->createElementNS($this->xmlns['xslt'], 'template');
		$template->setAttribute('match', '/');
		
		$stylesheet->appendChild($template);
		$template->appendChild($dom->documentElement->cloneNode(true));
		$dom->replaceChild($stylesheet, $dom->documentElement);
		
		
		// Add any namespace that is not yet in the document
		foreach ($this->xmlns as $prefix => $uri)
		{
			if (!$dom->documentElement->hasAttribute('xmlns:' . $prefix))
				$dom->documentElement->setAttribute('xmlns:' . $prefix, $uri);
		}
		
		// Create a new XPath parser and register all namespace URI's
		$xpath = new DOMXPath($dom);
		foreach ($this->xmlns as $prefix => $uri)
			$xpath->registerNamespace($prefix, $uri);
		
		// Find all XPath expressions in the XML
		$nodeList = $xpath->query('//*[contains(text(), "{@")]', $dom);
		foreach ($nodeList as $node)
		{
			// Extract the variables
			preg_match_all('/(\{@(\w+)\s+([^\s]+)\s+([^}]+)\})/', $node->nodeValue, $matches, PREG_SET_ORDER);
			
			// Most items can contain multiple expressions
			foreach($matches as $match)
			{
				list($_, $all, $location, $query, $expression) = $match;
					
				// Select all the target nodes
				$targetList = $xpath->query($query, $node);
				foreach ($targetList as $target)
				{
					// Insert the expression at the correct location
					// This is done by tokenizing because the start of a <for-each> can be in
					// a totally different node than the </for-each>. There is no way to do that
					// with the DOM
					$token = 'PHP-XSLT-TOKEN-' . md5(uniqid());
					$tokens[$token] = $expression;
					$tokenNode = $dom->createTextNode($token);
					
					switch($location)
					{
						case 'before':
							$target->parentNode->insertBefore($tokenNode, $target);
							break;
							
						case 'after':
							if ($target->nextSibling)
								$target->parentNode->insertBefore($tokenNode, $target->nextSibling);
							else
								$target->parentNode->appendChild($tokenNode);
							break;
						
						case 'replace':
							$target->parentNode->replaceChild($tokenNode, $target);
							break;
						
						case 'child':
							$target->appendChild($tokenNode);
							break;
					}
				}
				
				// Remove the XPath expression
				$node->nodeValue = str_replace($all, '', $node->nodeValue);
			}	
		}

		// Replace the tokens in text-mode
		$contents = $dom->saveXML();
		$contents = str_replace(array_keys($tokens), array_values($tokens), $contents);
		
		// Reload the DOM and XPath parser
		$dom->loadXML($contents);
		$xpath = new DOMXPath($dom);
		foreach ($this->xmlns as $prefix => $uri)
			$xpath->registerNamespace($prefix, $uri);
		
		// Remove all ODFTemplate script entities. They should be empty if there were no syntax errors
		$nodeList = $xpath->query('//text:script[@script:language="ODF-XSLT"]', $dom);
		foreach ($nodeList as $node)
			$node->parentNode->removeChild($node); 

		// Replace all the text placeholders with xslt:value-of elements
		$nodeList = $xpath->query('//text:placeholder[@text:description]', $dom);
		foreach ($nodeList as $node)
		{
			$placeholder = $node->getAttributeNS($this->xmlns['text'], 'description');
			$replacement = $dom->createElementNS($this->xmlns['xslt'], 'xslt:value-of');
			$replacement->setAttribute('select', $placeholder);
			$node->parentNode->replaceChild($replacement, $node);
		}
		
		// Add <xslt:attribute> elements to change update the office:value attributes on table cells
		$nodeList = $xpath->query('//table:table-cell[*/xslt:value-of and @office:value-type!="string"]', $dom);
		foreach ($nodeList as $node)
		{
			// Check if there already is an xslt:attribute element
			$xslt_attributes = $xpath->query('xslt:attribute[@name="office:value"]', $node);
			if ($xslt_attributes->length > 0)
				continue;

			// Find the xslt:value-of element. We will clone it.
			$value_of = $xpath->query('*/xslt:value-of', $node)->item(0);

			// Add the xslt:attribute
			$attribute = $dom->createElementNS($this->xmlns['xslt'], 'xslt:attribute');
			$attribute->setAttribute('name', 'office:value');
			$attribute->appendChild($value_of->cloneNode());
			$node->insertBefore($attribute, $node->firstChild);
		}

		// Done!
		$contents = $dom->saveXML();
		return $contents;
	}
}

?>
