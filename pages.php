
<?php
session_start();
	$pg=$_GET['page'];
		if($pg==base64_encode(homeload)){ include"modul/homeload.php"; }
		elseif($pg==base64_encode(home)){ include"modul/home.php"; }
		elseif($pg==base64_encode(hometicket)){ include"modul/hometicket.php"; }
		elseif($pg==base64_encode(homeptkp)){ include"modul/homeptkp.php"; }
// PENGATURAN UMUM
	// DATA KONFIGURASI
		elseif($pg==base64_encode(cnfset)){ include"modul/sys_config/conf_umum.php"; }
	// DATA ROLE & LOG
		elseif($pg==base64_encode(dtrole)){ include"modul/ms_role/role_data.php"; }
		elseif($pg==base64_encode(addrole)){ include"modul/ms_role/role_tambah.php"; }
		elseif($pg==base64_encode(edtrole)){ include"modul/ms_role/role_ubah.php"; }
		elseif($pg==base64_encode(dtlog)){ include"modul/ms_role/log_data.php"; }
	// DATA GROUP
		elseif($pg==base64_encode(dtgroup)){ include"modul/sys_group/sys_group_data.php"; }
		elseif($pg==base64_encode(addgroup)){ include"modul/sys_group/sys_group_tambah.php"; }
		elseif($pg==base64_encode(edtgroup)){ include"modul/sys_group/sys_group_ubah.php"; }
	// DATA MAIN MENU
		elseif($pg==base64_encode(dtmenu)){ include"modul/as_sys_menu/as_sys_menu_data.php"; }
		elseif($pg==base64_encode(addmenu)){ include"modul/as_sys_menu/as_sys_menu_add.php"; }
		elseif($pg==base64_encode(edtmenu)){ include"modul/as_sys_menu/as_sys_menu_edit.php"; }
	// DATA EDUCATION CENTER
		elseif($pg==base64_encode(dtsec)){ include"modul/as_ms_sec/as_ms_sec_data.php"; }
		elseif($pg==base64_encode(addsec)){ include"modul/as_ms_sec/as_ms_sec_add.php"; }
		elseif($pg==base64_encode(edtsec)){ include"modul/as_ms_sec/as_ms_sec_edit.php"; }
	// DATA BAGIAN
		elseif($pg==base64_encode(dtbagian)){ include"modul/sys_bagian/sys_bagian_data.php"; }
		elseif($pg==base64_encode(addbagian)){ include"modul/sys_bagian/sys_bagian_tambah.php"; }
		elseif($pg==base64_encode(edtbagian)){ include"modul/sys_bagian/sys_bagian_ubah.php"; }
	// DATA ORGANISASI
		elseif($pg==base64_encode(dtorg)){ include"modul/sys_org/sys_org_data.php"; }
		elseif($pg==base64_encode(addorg)){ include"modul/sys_org/sys_org_tambah.php"; }
		elseif($pg==base64_encode(edtorg)){ include"modul/sys_org/sys_org_ubah.php"; }
	// DATA JABATAN
		elseif($pg==base64_encode(dtjab)){ include"modul/sys_jab/sys_jab_data.php"; }
		elseif($pg==base64_encode(addjab)){ include"modul/sys_jab/sys_jab_tambah.php"; }
		elseif($pg==base64_encode(edtjab)){ include"modul/sys_jab/sys_jab_ubah.php"; }
	// DATA DATA MODUL
		elseif($pg==base64_encode(dtmdl)){ include"modul/ms_modul/ms_modul_data.php"; }
		elseif($pg==base64_encode(addmdl)){ include"modul/ms_modul/ms_modul_tambah.php"; }
		elseif($pg==base64_encode(edtmdl)){ include"modul/ms_modul/ms_modul_ubah.php"; }
// APLIKASI TICKETING 
	// DATA MASTER KETEGORI
		elseif($pg==base64_encode(ticdtktgr)){ include"modul/tic_ms_kat/tic_ms_kat_data.php"; }
		elseif($pg==base64_encode(ticaddktgr)){ include"modul/tic_ms_kat/tic_ms_kat_add.php"; }
		elseif($pg==base64_encode(ticedtktgr)){ include"modul/tic_ms_kat/tic_ms_kat_edit.php"; }
	// DATA MASTER TICKET & MODUL
		elseif($pg==base64_encode(ticdtmodul)){ include"modul/tic_ms_modul/tic_ms_modul_data.php"; }
		elseif($pg==base64_encode(ticaddmodul)){ include"modul/tic_ms_modul/tic_ms_modul_add.php"; }
		elseif($pg==base64_encode(ticedtmodul)){ include"modul/tic_ms_modul/tic_ms_modul_edit.php"; }
	// DATA LEVEL TICKET
		elseif($pg==base64_encode(ticdtlvl)){ include"modul/tic_ms_lvl/tic_ms_lvl_data.php"; }
		elseif($pg==base64_encode(ticaddlvl)){ include"modul/tic_ms_lvl/tic_ms_lvl_add.php"; }
		elseif($pg==base64_encode(ticedtlvl)){ include"modul/tic_ms_lvl/tic_ms_lvl_edit.php"; }
	// DATA TICKET
		elseif($pg==base64_encode(ticdttic)){ include"modul/tic_tr_tic/tic_tr_tic_data.php"; }
		elseif($pg==base64_encode(ticmanagtic)){ include"modul/tic_tr_tic/tic_tr_tic_manag.php"; }
		elseif($pg==base64_encode(ticaddtic)){ include"modul/tic_tr_tic/tic_tr_tic_add.php"; }
		elseif($pg==base64_encode(ticedttic)){ include"modul/tic_tr_tic/tic_tr_tic_edit.php"; }
		elseif($pg==base64_encode(ticprosestic)){ include"modul/tic_tr_tic/tic_tr_tic_proses.php"; }
		elseif($pg==base64_encode(ticapprovaltic)){ include"modul/tic_tr_tic/tic_tr_tic_approve.php"; }
	// SEMUA LAPORAN TICKET
		elseif($pg==base64_encode(ticreportticket)){ include"modul/ms_report/tic_report_start.php"; }
// APLIKASI LOADING 
	// DATA JENIS KENDARAAN
		elseif($pg==base64_encode(loaddtmsjnskend)){ include"modul/load_ms_jns_kend/load_ms_jns_kend_data.php"; }
		elseif($pg==base64_encode(loadaddmsjnskend)){ include"modul/load_ms_jns_kend/load_ms_jns_kend_add.php"; }
		elseif($pg==base64_encode(loadedtmsjnskend)){ include"modul/load_ms_jns_kend/load_ms_jns_kend_edit.php"; }
	// DATA PETUGAS
		elseif($pg==base64_encode(loaddtmspetugas)){ include"modul/load_ms_identitas/load_ms_identitas_data.php"; }
		elseif($pg==base64_encode(loadaddmspetugas)){ include"modul/load_ms_identitas/load_ms_identitas_add.php"; }
		elseif($pg==base64_encode(loadedtmspetugas)){ include"modul/load_ms_identitas/load_ms_identitas_edit.php"; }
	// DATA STANDARD
		elseif($pg==base64_encode(loaddtmsklasifikasi)){ include"modul/load_ms_klasifikasi/load_ms_klasifikasi_data.php"; }
		elseif($pg==base64_encode(loadaddmsklasifikasi)){ include"modul/load_ms_klasifikasi/load_ms_klasifikasi_add.php"; }
		elseif($pg==base64_encode(loadedtmsklasifikasi)){ include"modul/load_ms_klasifikasi/load_ms_klasifikasi_edit.php"; }
	// DATA MASUK KENDARAAN
		elseif($pg==base64_encode(loaddttrmasuk)){ include"modul/load_tr_masuk/load_tr_masuk_data.php"; }
		elseif($pg==base64_encode(loadaddtrmasuk)){ include"modul/load_tr_masuk/load_tr_masuk_add.php"; }
		elseif($pg==base64_encode(loadedttrmasuk)){ include"modul/load_tr_masuk/load_tr_masuk_edit.php"; }
		elseif($pg==base64_encode(loadcardtrmasuk)){ include"modul/load_tr_masuk/load_tr_masuk_card.php"; }
	// DATA KELUAR KENDARAAN
		elseif($pg==base64_encode(loaddttrkeluar)){ include"modul/load_tr_keluar/load_tr_keluar_data.php"; }
		elseif($pg==base64_encode(loadaddtrkeluar)){ include"modul/load_tr_keluar/load_tr_keluar_add.php"; }
		elseif($pg==base64_encode(loadedttrkeluar)){ include"modul/load_tr_keluar/load_tr_keluar_edit.php"; }
		elseif($pg==base64_encode(loadcardtrkeluar)){ include"modul/load_tr_keluar/load_tr_keluar_card.php"; }
	// SEMUA LAPORAN LOADING
		elseif($pg==base64_encode(lapbongkarmuattglmasuk)){ include"modul/ms_report/load_report_by_in.php"; }
		elseif($pg==base64_encode(lapbongkarmuattglkeluar)){ include"modul/ms_report/load_report_by_out.php"; }
// APLIKASI CONTROL DOCUMENT 
	// DATA JENIS DOKUMEN
		elseif($pg==base64_encode(docdtmsjnsdoc)){ include"modul/doc_ms_jns_doc/doc_ms_jns_doc_data.php"; }
		elseif($pg==base64_encode(docaddmsjnsdoc)){ include"modul/doc_ms_jns_doc/doc_ms_jns_doc_add.php"; }
		elseif($pg==base64_encode(docedtmsjnsdoc)){ include"modul/doc_ms_jns_doc/doc_ms_jns_doc_edit.php"; }
	// DATA KATEGORI DOKUMEN
		elseif($pg==base64_encode(docdtmskatdoc)){ include"modul/doc_ms_kat_doc/doc_ms_kat_doc_data.php"; }
		elseif($pg==base64_encode(docaddmskatdoc)){ include"modul/doc_ms_kat_doc/doc_ms_kat_doc_add.php"; }
		elseif($pg==base64_encode(docedtmskatdoc)){ include"modul/doc_ms_kat_doc/doc_ms_kat_doc_edit.php"; }
	// DATA MASTER DOKUMEN
		elseif($pg==base64_encode(docdtmsdoc)){ include"modul/doc_ms_doc/doc_ms_doc_data.php"; }
		elseif($pg==base64_encode(docaddmsdoc)){ include"modul/doc_ms_doc/doc_ms_doc_add.php"; }
		elseif($pg==base64_encode(docedtmsdoc)){ include"modul/doc_ms_doc/doc_ms_doc_edit.php"; }
		elseif($pg==base64_encode(docupdmsdoc)){ include"modul/doc_ms_doc/doc_ms_doc_upload.php"; }
		elseif($pg==base64_encode(docviewmsdoc)){ include"modul/doc_ms_doc/doc_ms_doc_view.php"; }
	// DATA USULAN & REGISTRASI DOKUMEN
		elseif($pg==base64_encode(docdttrusul)){ include"modul/doc_tr_usul/doc_tr_usul_data.php"; }
		elseif($pg==base64_encode(docaddtrusul)){ include"modul/doc_tr_usul/doc_tr_usul_add.php"; }
		elseif($pg==base64_encode(docedttrusul)){ include"modul/doc_tr_usul/doc_tr_usul_edit.php"; }
		elseif($pg==base64_encode(docupdtrusul)){ include"modul/doc_tr_usul/doc_tr_usul_upload.php"; }
		elseif($pg==base64_encode(docmsgtrusul)){ include"modul/doc_tr_usul/doc_tr_usul_comment.php"; }
		elseif($pg==base64_encode(docdtapptrusul)){ include"modul/doc_tr_usul/doc_tr_usul_data_app.php"; }
		elseif($pg==base64_encode(docaddapptrusul)){ include"modul/doc_tr_usul/doc_tr_usul_add_app.php"; }
		elseif($pg==base64_encode(docdtprosestrusul)){ include"modul/doc_tr_usul/doc_tr_usul_data_proses.php"; }
		elseif($pg==base64_encode(docaddprosestrusul)){ include"modul/doc_tr_usul/doc_tr_usul_add_proses.php"; }
	// DATA SUMBER PTKP
		elseif($pg==base64_encode(ptkpdtmssumber)){ include"modul/ptkp_ms_sumber/ptkp_ms_sumber_data.php"; }
		elseif($pg==base64_encode(ptkpaddmssumber)){ include"modul/ptkp_ms_sumber/ptkp_ms_sumber_add.php"; }
		elseif($pg==base64_encode(ptkpedtmssumber)){ include"modul/ptkp_ms_sumber/ptkp_ms_sumber_edit.php"; }
	// DATA KATEGORI TEMUAN PTKP
		elseif($pg==base64_encode(ptkpdtmskategori)){ include"modul/ptkp_ms_kategori/ptkp_ms_kategori_data.php"; }
		elseif($pg==base64_encode(ptkpaddmskategori)){ include"modul/ptkp_ms_kategori/ptkp_ms_kategori_add.php"; }
		elseif($pg==base64_encode(ptkpedtmskategori)){ include"modul/ptkp_ms_kategori/ptkp_ms_kategori_edit.php"; }
	// DATA DAMPAK TEMUAN
		elseif($pg==base64_encode(ptkpdtmsdampak)){ include"modul/ptkp_ms_dampak/ptkp_ms_dampak_data.php"; }
		elseif($pg==base64_encode(ptkpaddmsdampak)){ include"modul/ptkp_ms_dampak/ptkp_ms_dampak_add.php"; }
		elseif($pg==base64_encode(ptkpedtmsdampak)){ include"modul/ptkp_ms_dampak/ptkp_ms_dampak_edit.php"; }
	// DATA KETERKAITAN TEMUAN
		elseif($pg==base64_encode(ptkpdtmsketerkaitan)){ include"modul/ptkp_ms_terkait/ptkp_ms_terkait_data.php"; }
		elseif($pg==base64_encode(ptkpaddmsketerkaitan)){ include"modul/ptkp_ms_terkait/ptkp_ms_terkait_add.php"; }
		elseif($pg==base64_encode(ptkpedtmsketerkaitan)){ include"modul/ptkp_ms_terkait/ptkp_ms_terkait_edit.php"; }
	// DATA PTKP
		elseif($pg==base64_encode(ptkpdttrptkp)){ include"modul/ptkp_tr_ptkp/ptkp_tr_ptkp_data.php"; }
		elseif($pg==base64_encode(ptkpaddtrptkp)){ include"modul/ptkp_tr_ptkp/ptkp_tr_ptkp_add.php"; }
		elseif($pg==base64_encode(ptkpedttrptkp)){ include"modul/ptkp_tr_ptkp/ptkp_tr_ptkp_edit.php"; }
		elseif($pg==base64_encode(ptkpdttrtrmptkp)){ include"modul/ptkp_tr_ptkp/ptkp_tr_ptkp_trm_data.php"; }
		elseif($pg==base64_encode(ptkpaddtrtrmptkp)){ include"modul/ptkp_tr_ptkp/ptkp_tr_ptkp_trm_add.php"; }
		elseif($pg==base64_encode(ptkpdtmonitortrptkp)){ include"modul/ptkp_tr_ptkp/ptkp_tr_ptkp_mtr_data.php"; }
		elseif($pg==base64_encode(ptkpaddmonitortrptkp)){ include"modul/ptkp_tr_ptkp/ptkp_tr_ptkp_mtr_add.php"; }
	// DATA PTKP REPORT
		elseif($pg==base64_encode(ptkpreportptkp)){ include"modul/ms_report/ptkp_report_by_tgl.php"; }
		elseif($pg==base64_encode(docreportperubahandoc)){ include"modul/ms_report/doc_report_perubahan_dokumen.php"; }

	// FRONTEND
		elseif($pg==base64_encode(standardglobal)){ include"standard_global.php"; }
		elseif($pg==base64_encode(standardglobalview)){ include"standard_global_view.php"; }
		elseif($pg==base64_encode(standarddepartemen)){ include"standard_bagian.php"; }
		elseif($pg==base64_encode(standarddepartemenview)){ include"standard_bagian_view.php"; }
		elseif($pg==base64_encode(sec)){ include"sec.php"; }
		elseif($pg==base64_encode(secview)){ include"sec_view.php"; }
		elseif($pg==base64_encode(meetingschedule)){ include"meeting_schedule.php"; }
		elseif($pg==base64_encode(meetingscheduleview)){ include"meeting_schedule_view.php"; }
		elseif($pg==base64_encode(ticketing)){ include"ticketing.php"; }
		elseif($pg==base64_encode(ticketingview)){ include"ticketing_view.php"; }
		elseif($pg==base64_encode(extention)){ include"extention.php"; }
	// DATA MASTER ROOM
		elseif($pg==base64_encode(masterroomadd)){ include"modul/as_ms_room/as_ms_room_add.php"; }
		elseif($pg==base64_encode(masterroomdata)){ include"modul/as_ms_room/as_ms_room_data.php"; }
		elseif($pg==base64_encode(masterroomedit)){ include"modul/as_ms_room/as_ms_room_edit.php"; }
	// DATA MEETING SCHEDULE
		elseif($pg==base64_encode(addtrxmeetsch)){ include"modul/as_trx_meet_sch/as_trx_meet_sch_add.php"; }
		elseif($pg==base64_encode(dttrxmeetsch)){ include"modul/as_trx_meet_sch/as_trx_meet_sch_data.php"; }
		elseif($pg==base64_encode(edttrxmeetsch)){ include"modul/as_trx_meet_sch/as_trx_meet_sch_edit.php"; }
		elseif($pg==base64_encode(notulentrxmeetsch)){ include"modul/as_trx_meet_sch/as_trx_meet_sch_notulen.php"; }
		elseif($pg==base64_encode(edtnotulentrxmeetsch)){ include"modul/as_trx_meet_sch/as_trx_meet_sch_notulen_edit.php"; }
	// DATA MASTER EMPLOYEE
		elseif($pg==base64_encode(masteremployeeadd)){ include"modul/sys_master_employee/master_employee_add.php"; }
		elseif($pg==base64_encode(masteremployeedata)){ include"modul/sys_master_employee/master_employee_data.php"; }
		elseif($pg==base64_encode(masteremployeeedit)){ include"modul/sys_master_employee/master_employee_edit.php"; }
	// DATA EXTENTION NUMBER
		elseif($pg==base64_encode(extentionnumberadd)){ include"modul/as_ms_ext/as_ms_ext_add.php"; }
		elseif($pg==base64_encode(extentionnumberdata)){ include"modul/as_ms_ext/as_ms_ext_data.php"; }
		elseif($pg==base64_encode(extentionnumberedit)){ include"modul/as_ms_ext/as_ms_ext_edit.php"; }
	// DATA IT NOTE
		elseif($pg==base64_encode(itnoteadd)){ include"modul/it_note/it_note_add.php"; }
		elseif($pg==base64_encode(itnotedata)){ include"modul/it_note/it_note_data.php"; }
		elseif($pg==base64_encode(itnoteedit)){ include"modul/it_note/it_note_edit.php"; }
	// DATA PEMERIKSAAN
		elseif($pg==base64_encode(dttrperiksa)){ include"modul/as_trx_periksa/as_trx_periksa_data.php"; }
		elseif($pg==base64_encode(addtrperiksa)){ include"modul/as_trx_periksa/as_trx_periksa_add.php"; }
		elseif($pg==base64_encode(edttrperiksa)){ include"modul/as_trx_periksa/as_trx_periksa_edit.php"; }
		else {
		echo "<div class='alert alert-dismissable alert-danger'><i class='fa fa-times'></i> Belum ada modul / dalam tahap pengembangan</div>";
		}
?>
		
		