<?php 

class Dashboard extends CI_Controller{
	public function index()
	{
		$data['title']="Halaman Customer";
		$data['mobil']=$this->rental_model->get_data('mobil')->result();
		$this->load->view('templates_customer/header',$data);
		$this->load->view('customer/dashboard',$data);
		$this->load->view('templates_customer/footer');
	}

	public function rental($id)
	{
		$data['title']="Form Rental Mobil";
		$where = array('id_mobil' => $id );
		$data['mobil']=$this->rental_model->detail_data('mobil',$where)->result();
		$this->load->view('templates_customer/header',$data);
		$this->load->view('customer/rental',$data);
		$this->load->view('templates_customer/footer');
	}

	public function rental_aksi()
	{
		$id_customer=$this->session->userdata('id_customer');
		$id_mobil=$this->input->post('id_mobil');
		$harga=$this->input->post('harga');
		$denda=$this->input->post('denda');
		$tanggal_rental=$this->input->post('tanggal_rental');
		$tanggal_kembali=$this->input->post('tanggal_kembali');

		$data = array(
			'id_customer' => $id_customer,
			'id_mobil' => $id_mobil,
			'harga' => $harga,
			'denda' => $denda,
			'tanggal_rental' => $tanggal_rental,
			'tanggal_kembali' => $tanggal_kembali,
			'status_pengembalian' => 'Belum Selesai',
			'status_rental' => 'Belum Selesai'
		 );

		$this->rental_model->insert_data('transaksi',$data);
		$data = array('status' => '0' );
		$where = array('id_mobil' => $id_mobil );
		$this->rental_model->update_data('mobil',$data,$where);
		$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Mobil Berhasil Dirental!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>');
		redirect('customer/dashboard');
	}

}



 ?>