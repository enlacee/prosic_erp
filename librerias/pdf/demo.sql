use demo;
#----------------------------
# Table structure for empresa
#----------------------------
CREATE TABLE `empresa` (
	`idemp` int(11) NOT NULL auto_increment,
	`nombre` varchar(180) NOT NULL default '',
	`direccion` varchar(180) NOT NULL default '',
	`telefono` int(8) NOT NULL default '0',
	`imagen` varchar(50) NOT NULL default '',
	PRIMARY KEY  (`idemp`)
);
#----------------------------
# Records for table empresa
#----------------------------
insert  into empresa values 
(4, 'Pesacon', 'Jr. Los Astrónomos Mz. C 11 Lt. 13', 3872056, 'b55dd5_001048 balanzas pesacon.jpg'), 
(46, 'Quipu Digital', 'Carret. Central Km. 21, 730', 3584531, '424cce_001040 internet quipu digital.jpg'), 
(13, 'Courier Cristiano Jeshua', 'Jr. Risso 538', 96464860, 'd621a7_001103 courier jeshua.jpg'), 
(17, 'Serv. Ledesma SAC', 'Prolg. Iquitos 2200', 2659006, 'ledesma.jpg'), 
(18, 'Sonido Profesional Arriola', 'Alicia Alarcón 400', 4820496, '7a88d4_001416 equipos de sonido arriola.jpg'), 
(25, 'Juegos Emperatriz', 'Teodoro Cárdenas 790, Sta. Beatriz', 4714603, 'fc0c9b_002216 juego recreativos.jpg'), 
(27, 'Stockholm Hipermedia S.A.', 'Los Calderos 140, Urb. Vulcano', 3494222, '898810_001044 muebles stockhom.jpg'), 
(28, 'Notaria Beatriz Zevallos G.', 'Av. Túpac Amaru 782, 2º Piso', 4852526, 'd02fcf_001025 notaria giampietri.jpg'), 
(30, 'A & B Hidrosistemas SAC', 'Av. Tomás Marsano 1265', 2710263, 'cb2dc7_002207 Hidrosistemas.jpg'), 
(33, 'Macro Work SAC', 'Calle La Habana 280', 4222122, 'a92b21_002003 macro word.jpg'), 
(36, 'Per Systems SA', 'Av. Arenales 2523', 4226322, '32f133_002086-per-antivirus.jpg'), 
(37, 'Transporte Torre Fuerte', 'Calle Costa Azul Mz. B Lt. 16', 2511749, 'cdcd2d_002113 transporte torre fuerte 1.jpg'), 
(51, 'Global Medica', 'Jr. Pablo Bermudez 192', 4336470, '556cd1_001375 clinica global medica.jpg'), 
(39, 'Distribuidora Mesajil Hnos.', 'Jr. Camaná 1163', 4239453, '9be658_002002 mesajil hnos s.a.c.jpg'), 
(55, 'Lima International School', 'Av. La Molina 1255, Sol de La Molina', 4790846, '2a5958_002213school tomorrow 3.jpg'), 
(59, 'Sandwiches Passatore', 'Jr. Toribio Seminario 696', 4508684, '46d48f_002208 sandwiches passatore.jpg'), 
(61, 'Publimedios', 'Av. Independencia 879, Huamanga', 312436, '9c6a82_002226 publicistas publimedios.jpg'), 
(63, 'AJEPER', 'Av. La Paz Lt.30, Sta. María de Huachipa', 3711812, 'a31ad0_gaseosas ajeper 001404.jpg');

