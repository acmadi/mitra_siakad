<?php
// Proses Login
// Author: SIAKAD TEAM
// 13 Desember 2005

// *** Main ***
//die($_REQUEST['gos']);
$gos = (empty($_REQUEST['gos']))? 'cek' : $_REQUEST['gos'];
$gos();

// *** Functions ***
function gagal() {
   //echo $_err = ErrorMsg("Login Gagal", 
    // "Login dan Password yang Anda masukkan tidak valid.<br>
     //Hubungi Administrator untuk informasi lebih lanjut.<hr size=1 color=black>
     //Pilihan: <a href='?mnux='>Login</a> | <a href='?mnux='>Kembali</a>");
	 ?>
	 <img src="img/failed.jpg" alt="Login Gagal" width="72">
	 <p style="color:#000;font-size:14px;">Maaf Login Gagal</p>
	 "Login dan Password yang Anda masukkan tidak valid.<br>
     Hubungi Administrator untuk informasi lebih lanjut.<hr size=1 color=black>
	  <a href='?mnux='>Login</a> | <a href='?mnux='>Kembali</a>
	 <?php
}
function berhasil() {
  global $_ProductName, $_Version, $arrID;
// Tampilkan welcome
 // TampilkanJudul("Selamat Datang");
  /*echo Konfirmasi("$arrID[Nama]", 
    "<table class=bsc cellspacing=1 width=100%>
    <tr>
    <td class=ul1 colspan=2 nowrap>Selamat datang di $_ProductName - $arrID[Nama]</td>
    </tr>
    <tr>
      <td class=inp>Nama :</td>
      <td class=ul1><b>$_SESSION[_Nama]</b></td>
    </tr>
    <tr>
      <td class=inp>LevelID :</td>
      <td class=ul1><b>$_SESSION[_LevelID]</b></td>
    </tr>
    <tr>
      <td class=inp>Institusi :</td>
      <td class=ul1><b>$_SESSION[_KodeID]</b></td>
    </tr>
    <tr>
      <td class=inp>Session :</td>
      <td class=ul1>$_SESSION[_Session]</td>
      </tr>
    <tr>
      <td class=inp>Pilihan:</td>
      <td class=ul1>
      <input type=button name='Logout' value='Logout' onClick=\"location='?mnux=loginprc&gos=lout'\" />
      </td>
    </tr>
    </table>");
	*/
	echo Konfirmasi("$arrID[Nama]", 
    "Selamat datang $_SESSION[_Nama] di SIAKAD $arrID[Nama] ");
}
function cek() {
  global $arrID;
  $_tbl = GetaField('level', 'LevelID', $_REQUEST['lid'], 'TabelUser');
  $Institusi = $_REQUEST['institusi'];
  $s = "select * from $_tbl 
    where Login='$_REQUEST[Login]'
      and LevelID = '$_REQUEST[lid]' 
      and KodeID = '".KodeID."' 
      and NA = 'N'
      and Password=LEFT(PASSWORD('$_REQUEST[Password]'),10) limit 1";
  $r = _query($s);
  $_dat = _fetch_array($r);
  if (empty($_dat)) {
    gagal();
  }
  else {
    $sid = session_id();
    // Set Parameter
    $_SESSION['_Login'] = $_REQUEST['Login'];
    $_SESSION['_Nama'] = $_dat['Nama'];
    $_SESSION['_TabelUser'] = $_tbl;
    $_SESSION['_LevelID'] = $_REQUEST['lid'];
    $_SESSION['_Session'] = $sid;
    $_SESSION['_Superuser'] = $_dat['Superuser'];
    $_SESSION['_ProdiID'] = $_dat['ProdiID'];
	$_SESSION['KodeID'] = $Institusi;
    $_SESSION['_KodeID'] = $Institusi;
    $_SESSION['mnux'] = 'login';
    $_REQUEST['lgn'] = 'berhasil';
    // Refresh
    echo "<script>window.location='?mnux=loginprc&gos=berhasil';</script>";
  }
}
function lout() {
  ResetLogin();
  echo "<script>window.location='?mnux=';</script>";
}
?>
