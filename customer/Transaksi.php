<?php 	

class Transaksi extends CI_Controller{
	public function index()
	{
		$customer=$this->session->userdata('id_customer');
		$data['transaksi']=$this->db->query("SELECT * FROM transaksi tr, mobil mb, customer cs WHERE tr.id_mobil=mb.id_mobil AND tr.id_customer=cs.id_customer AND tr.id_customer='$customer'")->result();
		$data['title']="Halaman Transaksi";
		$this->load->view('templates_customer/header',$data);
		$this->load->view('customer/transaksi',$data);
		$this->load->view('templates_customer/footer');
	}


	public function cek_pembayaran($id)
	{
		$customer=$this->session->userdata('id_rental');
		$data['transaksi']=$this->db->query("SELECT * FROM transaksi tr, mobil mb, customer cs WHERE tr.id_mobil=mb.id_mobil AND tr.id_customer=cs.id_customer AND tr.id_rental='$id'")->result();
		$data['title']="Halaman Pembayaran";
		$this->load->view('templates_customer/header',$data);
		$this->load->view('customer/cek_pembayaran',$data);
		$this->load->view('templates_customer/footer');
	}

	public function pembayaran_aksi()
	{
		$id_rental=$this->input->post('id_rental');
		$bukti_pembayaran=$_FILES['bukti_pembayaran']['name'];
		if ($bukti_pembayaran='') {}else{
			$config['upload_path']='./assets/upload';
			$config['allowed_types']='jpeg|jpg|png|pdf|tiff';
			$this->load->library('upload',$config);
			if (!$this->upload->do_upload('bukti_pembayaran')) {
				echo "gambar gagal di upload";
			}else{
				$bukti_pembayaran=$this->upload->data('file_name');

			}

		}

		$data = array(
			'bukti_pembayaran' => $bukti_pembayaran,
			'status_pembayaran' =>'0'
	);
		$where = array('id_rental' => $id_rental );

		$this->rental_model->update_data('transaksi',$data,$where);
		$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Bukti Pembayaran Telah Terkirim!!!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>');
		redirect('customer/transaksi');
	}



	public function print($id)
	{
		$data['transaksi']=$this->db->query("SELECT * FROM transaksi tr, mobil mb, customer cs WHERE tr.id_mobil=mb.id_mobil AND tr.id_customer=cs.id_customer AND tr.id_rental='$id'")->result();
		$data['title']="Halaman Print";
		$this->load->view('templates_customer/header',$data);
		$this->load->view('customer/print',$data);
		$this->load->view('templates_customer/footer');
	}

}


 ?>