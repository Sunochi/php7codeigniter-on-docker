<?php
class Blog_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	// データベースからすべての記事を取得するメソッド
	function get_all_posts(){

		// entryのカラムから情報を取得して、queryに格納
		$query = $this->db->get("entry");

		// entryカラム情報を持ったqueryをresultに挿入
		// result()メソッドは、結果をオブジェクトの配列として、または失敗した場合には 空の配列 を返します。
		return $query->result();
	}

	function add_new_entry($name, $body){
		$data = array(
			"entry_name" => $name,
			"entry_body" => $body
		);
		$this->db->insert("entry", $data);
	}
}
