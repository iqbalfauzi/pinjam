<table border="1">
	<tr>
		<td>No</td>
		<th>NIM</th>
		<th>Nama</th>
		<th>Fakultas</th>
		<th>Jurusan</th>
		<th>Contest</th>
	</tr>

	<tr>
		<?php
		$no=1;
		foreach ($databea as $row) {
			?>
			<td><?php echo $no++; ?></td>
			<td><?php echo $row->nim ?></td>
			<td><?php echo $row->nama ?></td>
			<td><?php echo $row->namaJur ?></td>
			<td><?php echo $row->namaFk ?></td>
			<td><?php echo $row->nama_contest ?></td>
		</tr>
		<?php } ?>
	</table>


	<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=data_mahasiswa_lolos_seleksi.xls");
	?>

