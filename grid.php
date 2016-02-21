<?php

/**
 * GRID
 *
 * A Codeigniter library
 *
 * Copyright (C) 2015 Dmitriy Korobka. 
 *
 * LICENSE
 *
 * GRID is released with dual licensing, using the GPL v3 (license-gpl3.txt) and the MIT license (license-mit.txt).
 * You don't have to do anything special to choose one license or the other and you don't have to notify anyone which license you are using.
 * Please see the corresponding license file for details of these licenses.
 * You are free to use, modify and distribute this software, but all copyright information must remain.
 *
 * @package    	GRID
 * @copyright  	Copyright (c) 2015 through 2010, Dmitriy Korobka
 * @license    	https://github.com/korobkadima/grid
 * @version    	0.1
 * @author     	Dmitriy Korobka <korobka.dima@gmail.com>
 */

class grid {

	protected $table         = null;
	protected $pk            = null;
	protected $limit         = null;
	protected $column        = array();
	protected $column_names  = array();
	protected $column_format = array();
	protected $button        = array();
	
	function __construct() {
		
		$this->ci = &get_instance();
	}
	
	function set_table($table)
	{
		$this->table = $table;
		
		return $this;
	}
	
	function set_pk($pk)
	{
		$this->pk = $pk;
		
		return $this;
	}
	
	function set_limit($limit)
	{
		$this->limit = $limit;
	}
		
	function set_select($column = array())
	{
		return $this->column = $column;
	}
	
	function set_name($col,$name)
	{
		$this->column_names[$col] = $name;
	}
	
	function set_format($col,$func)
	{
		$this->column_format[$col] = $func;
	}
	
	function set_button($url,$name)
	{
		$this->button[$name] = $url;
	}
	
	function set_button_function($name,$func)
	{
		$this->button_function[$name] = $func;
	}
		
	/* */
	
	protected function _format(&$item,$key,$func)
	{
		$arr = $item;
		
		foreach($item as $k => $v)
	
		if(isset($func[$k]))
		{
			$item[$k] = call_user_func_array($func[$k],array($v, $arr));
		}
	}
	
	protected function _get($table)
	{
		/* CI Active Records */
		return $this->ci->db->get($table);
	}
	
	protected function _count($result)
	{
		/* CI Active Records */
		return $result->num_rows();
	}
	
	protected function _result($result)
	{
		/* CI Active Records */
		return $result->result_array();
	}
	
	protected function _limit($limit)
	{
		/* CI Active Records */
		return $this->ci->db->limit($limit);
	}
	
	protected function _select($column = array())
	{
		/* CI Active Records */
		return $this->ci->db->select($column);
	}
	
	protected function _add_col($out = array())
	{
		foreach($this->column_names as $k => $v)
		{
			if(!in_array($k,$this->column)) 
			
			foreach($out as $kout => $vout)
			{
				$out[$kout][$k] = '';
			}
		}
			
		return $out;	
	}
		
	protected function _prepare()
	{
		if(count($this->column) > 0)
		$this->_select($this->column);
		
		if($this->limit > 0)
		$this->_limit($this->limit);
		
		$data = $this->_get($this->table);
		
		if($this->_count($data) > 0)
		{
			$out = $this->_result($data);
			
			$out = $this->_add_col($out);
						
			if(count($this->column_format) > 0)
			array_walk($out,array(&$this, '_format'),$this->column_format);
			
			return $out;
		}
	}
	
	protected function _prepare_table()
	{
		$data = $this->_prepare();
	
		if(count($data) < 1) return false;
		
		$out = '<table border="1" width="100%">';
		
		$out .= '<tr>';
		
		if(count($this->column_names) > 0)
		{
			foreach($this->column_names as $key => $val)
			{
				$out .= '<th>'.$val.'</th>';
			}
		}
					
		if(count($this->button) > 0)
		{
			foreach($this->button as $key => $val)
			{
				$out .= '<th>'.$key.'</th>';
			}
		} 
		
		if(count($this->button_function) > 0)
		{
			foreach($this->button_function as $key => $val)
			{
				$out .= '<th>'.$val.'</th>';
			}
		} 
					
		$out .= '</tr>';
		
		foreach($data as $key => $val)
		{
			$out .= '<tr>';
			
			foreach($this->column_names as $keycol => $valcol)
			{
				$out .= '<td>'.$val[$keycol].'</td>';
			}

			$out .= '</tr>';
		}
						
		$out .= '</table>';
		
		return $out;
	}
	
	function return_table()
	{
		return($this->_prepare_table());
	}

	function print_table()
	{
		print($this->_prepare_table());
	} 
} 