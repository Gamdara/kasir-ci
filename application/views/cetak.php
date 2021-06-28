<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Cetak</title>
</head>
<body>
	<div style="width: 300px; margin: auto;">
		<br>
		<center>
			<h3><?php echo $this->session->userdata('toko')->nama; ?></h3>
			<?php echo $this->session->userdata('toko')->alamat; ?><br>
			mastha@gmail.com<br>
			0812345678910<br>
			www.mastha.com<br>
			
			<hr>
			<table width="100%">
				
					<tr>
						<td>
							<b>No.Nota</b>
						</td>
						<td align="center">
							:
						</td>
						<td>
							<?php echo $nota ?>
						</td>
					</tr>
					<tr>
						<td>
							<b>Waktu</b>
						</td>
						<td align="center">
							:
						</td>
						<td>
							<?php echo $tanggal ?>
						</td>
					</tr>
					<tr>
						<td>
							<b>Order</b>
						</td>
						<td align="center">
							:
						</td>
						<td>
							<?php echo $jumlah_produk ?>
						</td>
					</tr>
					<tr>
						<td>
							<b>Kasir</b>
						</td>
						<td align="center">
							:
						</td>
						<td>
							<?php echo $kasir ?>
						</td>
					</tr>
					<tr>
						<td>
							<b>Customer</b>
						</td>
						<td align="center">
							:
						</td>
						<td>
							<?php echo $nama_pelanggan ?>
						</td>
					</tr>
				
			</table>
			<hr>
			<table width="100%">
			<?php foreach ($produk as $key): ?>
				<tr>
					<td>
						<?php echo $key->nama_produk ?>
					</td>
						<?php if($level == "reseller") {?>
					<td align="right" style="">
						<?php echo $key->harga_reseller ?>
					</td>
						<?php }?>
						<?php if($level != "reseller") {?>
					<td align="right">
						<?php echo $key->harga_jual ?>
					</td>
						<?php }?>
				</tr>
				<?php endforeach ?>
			</table>
			<hr>
			<table width="100%">
				<tr>
					<td>
						<b>Subtotal <?php echo $jumlah_produk ?> Produk</b>
					</td>
					<td align="right">
						<?php echo $total ?>
					</td>
				</tr>
				<tr>
					<td>
						<b>Total Tagihan</b>
					</td>
					<td align="right">
						<?php echo $total ?>
					</td>
				</tr>
			</table>
			<hr>
			<table width="100%">
				<tr>
					<td>
						<?php if($jenis_bayar != 'cash') {?>
						<b>Transfer Bank</b>
						<?php } ?>
						<?php if($jenis_bayar == 'cash') {?>
						<b>Cash</b>
						<?php } ?>
						<br>
						<?= $jenis_bayar == 'cash' ? '' : $bank  ?>
					</td>
					<td width="23%" align="right">
						<?php echo $total ?>
					</td>
				</tr>
				<tr>
					<td>
						<b>Total Bayar</b>
					</td>
					<td width="23%" align="right">
						<?php echo $bayar ?>
					</td>
				</tr>
				<tr>
					<td>
						<b>Kembalian</b>
					</td>
					<td align="right">
						<?php echo $kembalian ?>
					</td>
				</tr>
			</table>
			<hr>
			<hr>
			<table width="100%">
				<tr align="center">
					<td><b>Terimakasih, Semoga Sehat Selalu</b></td>
				</tr>
				<tr align="center">
					<td><b>Terbayar</b></td>
				</tr>
				<tr align="center">
					<td><b><?php echo $tanggal ?></b></td>
				</tr>
			</table>
			<hr>
		</center>

	</div>
	<script>
		window.print()
	</script>
</body>
</html>