<?php
class Blog extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("blog_model");
	}

    // データベースからすべてのエントリーを取得するメソッド
    function index(){
	   // blog_modelのget_all_postメソッドを実行して、データをqueryに格納
	   $data['query'] = $this->blog_model->get_all_posts();
	   $this->load->view("index", $data);
    }

	function add_new_entry(){
		$this->load->helper("form");
		// form_validationとsessionライブラリを読み込む
		$this->load->library(array("form_validation", "session"));

		// バリデーションルールの設定
		$this->form_validation->set_rules("entry_name", "タイトル", "required|max_length[200]");
		$this->form_validation->set_rules("entry_body", "本文", "required");

		if( $this->form_validation->run() == FALSE ){
			// フォームバリデーションエラーが起きたら以下を実行
			// ページの初回読み込み時は自動的に起動
			$this->load->view("add_new_entry");
		}else{
			// POSTされた内容を変数に格納する
			$name = $this->input->post("entry_name");
			$body = $this->input->post("entry_body");

			// add_new_entryモデルを実行し、POSTデータを投げる
			$this->blog_model->add_new_entry($name, $body);

			// "フラッシュデータ"
			// 通知メッセージやステータスメッセージ(ex:レコード2は削除されました)によく利用されます。
			$this->session->set_flashdata("message", "記事が追加されました");

			// $this->load->view()の場合と表記法法が異なることに注意
			redirect("blog/add_new_entry");

		}
	}
}
