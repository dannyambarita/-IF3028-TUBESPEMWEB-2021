<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Lapor extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('menu_model');
        $this->load->helper('url_helper');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->load->view('lapor/index', /*$data*/);
    }

    public function tambah()
    {
        $isi = $this->input->post('isi');
        $aspek = $this->input->post('aspek');
        $tanggal = date("Y-m-d H:i:s");
        $lampiran = $_FILES['berkas']['name'];
        if ($lampiran = '') {
        } else {
            $berkas = array([
                'upload_path' => './file/',
                'allowed_types' => 'gif|jpg|png|doc|docx|xls|xlsx|ppt|pptx|pdf',
                'file_name'  => date('Y-m-d H-i-s', time())
            ]);
            /*$config['upload_path']      = './lampiran/';
            $config['allowed_types']    = 'jpg|png|gif';
            $config['file_name']        = date('Y-m-d H-i-s', time());*/

            $this->load->library('upload', $berkas);

            if (!$this->upload->do_upload('berkas')) {
                echo "gagal";
            } else {
                $this->upload->data('file_name');
            }

            //https://kursuswebprogramming.com/cara-input-tanggal-otomatis-menggunakan-php-mysql/
            //buat nampilin tanggal nanti
            $data = array(
                'isi' => $isi,
                'aspek' => $aspek,
                'waktu' => $tanggal,
                'file' => $lampiran
            );

            $this->db->insert('laporan', $data);
            redirect('menu');
        }
    }
}
