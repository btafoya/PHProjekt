<?php
/**
 * Tree node iterator
 *
 * LICENSE: Licensed under the terms of the PHProjekt 6 License
 *
 * @copyright  2007 Mayflower GmbH (http://www.mayflower.de)
 * @license    http://phprojekt.com/license PHProjekt 6 License
 * @version    CVS: $Id:
 * @package    PHProjekt
 * @link       http://www.phprojekt.com
 * @since      File available since Release 1.0
 * @author     David Soria Parra <david.soria_parra@mayflower.de>
 */

/**
 * Iterates over a set of tree nodes. You can use foreach statements
 * to iterate over a tree and its child nodes. As it impelements a
 * recursive iterator, the tree node iterator always iterates over
 * the children nodes.
 * See PHP-SPL for more information about the Iterator interfaces in
 * PHP 5.2.x and above.
 *
 * @copyright  2007 Mayflower GmbH (http://www.mayflower.de)
 * @version    Release: @package_version@
 * @license    http://phprojekt.com/license PHProjekt 6 License
 * @package    PHProjekt
 * @link       http://www.phprojekt.com
 * @since      File available since Release 1.0
 * @author     David Soria Parra <david.soria_parra@mayflower.de>
 */
class Phprojekt_Tree_Node_Iterator implements RecursiveIterator
{
    /**
     * Initialize
     *
     * @param array $children
     */
	function __construct($children)
	{
		if (is_array($children))
			$this->_children = $children;
		else
			$this->_children = array($children);
	}

	/**
	 * Returns the current item
	 *
	 * @see Iterator::current()
	 *
	 * @return Phprojekt_Tree_Node
	 */
	public function current()
	{
		return current($this->_children);
	}

	/**
	 * Returns the id/key for the current entry
	 *
	 * @see Iterator::key()
	 *
	 * @return mixed
	 */
	public function key()
	{
		return $this->current()->id;
	}

	/**
	 * Move forward to the next item
	 *
	 * @see Iterator::next()
	 *
	 * @return void
	 */
	public function next()
	{
		next($this->_children);
	}

	/**
	 * Reset to the first element
	 *
	 * @see Iterator::rewind()
	 *
	 * @return void
	 */
	public function rewind()
	{
		reset($this->_children);
	}

	/**
	 * Checks if the current entry is valid
	 *
	 * @see Iterator::valid()
	 *
	 * @return boolean
	 */
	public function valid()
	{
		return (boolean) $this->current();
	}

	/**
	 * Checks if the node has children to move forward to receive them
	 * using getChildren() if it has children
	 *
	 * @see RecursiveIterator::hasChildren()
	 *
	 * @return boolean
	 */
	public function hasChildren()
	{
		return (boolean) $this->current()->hasChildren();
	}

	/**
	 * Returns an new iterator for the children of the current node
	 *
	 * @see RecursiveIterator::getChildren()
	 *
	 * @return RecursiveIterator
	 */
	public function getChildren()
	{
		return new self($this->current()->getChildren ());
	}

}
