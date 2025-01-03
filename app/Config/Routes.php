<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes('false');
$routes->set404Override();
$routes->setAutoRoute(true);

# Pendaftaran & Login
$routes->get('/', 'RegisterLoginController::index');
$routes->get('/register_login', 'RegisterLoginController::index');
$routes->post('/processRegister', 'RegisterLoginController::processRegister');
$routes->post('/processLogin', 'RegisterLoginController::processLogin');

# Lupa Password
$routes->get('/forgot_password', 'ForgotPasswordController::forgotPassword');
$routes->post('/processForgotPassword', 'ForgotPasswordController::processOTP');
$routes->post('/processNewPassword', 'ForgotPasswordController::processNewPassword');
$routes->get('/password_baru', 'ForgotPasswordController::newPassword');

# Menu
$routes->get('/dashboard', 'DashboardController::index');
## Kalender
$routes->get('/kalender', 'KalenderController::kalender');
$routes->post('/addJadwal', 'KalenderController::addJadwal');
$routes->post('/updateJadwal/(:num)', 'KalenderController::updateJadwal/$1');
$routes->delete('/deleteJadwal/(:num)', 'KalenderController::deleteJadwal/$1');
## Proposal
$routes->get('/proposal_penelitian', 'ProposalPenelitianController::ProposalPenelitian');
$routes->post('/uploadProposal', 'ProposalPenelitianController::uploadProposal');
$routes->post('/updateProposal', 'ProposalPenelitianController::updateProposal');
$routes->get('/getProposalById/(:num)', 'ProposalPenelitianController::getProposalById/$1');
$routes->post('deleteProposal/(:num)', 'ProposalPenelitianController::deleteProposal/$1');
$routes->get('/preview_pdf', 'PreviewPdfController::previewPdf');
## Laporan Kemajuan
$routes->get('/laporan_kemajuan', 'LaporanKemajuanController::LaporanKemajuan');
$routes->get('/laporan_akhir', 'LaporanAkhirController::LaporanAkhir');
$routes->get('/publikasi', 'PublikasiController::publikasi');
$routes->get('/haki', 'HakiController::Haki');
$routes->get('/setting', 'SettingController::setting');
$routes->get('/profile', 'ProfileController::profile');
## Publikasi
$routes->get('/publikasi', 'PublikasiController::Publikasi');
$routes->post('/uploadPublikasi', 'PublikasiController::uploadPublikasi');
$routes->post('/updatePublikasi/(:num)', 'PublikasiController::updatePublikasi/$1');
$routes->post('deletePublikasi/(:num)', 'PublikasiController::deletePublikasi/$1');
$routes->get('/preview_pdf', 'PreviewPdfController::previewPdf');
## HAKI
$routes->get('/Haki', 'HakiController::Haki');
$routes->post('/uploadHAKI', 'HakiController::uploadHAKI');
$routes->post('/updateHaki/(:num)', 'HakiController::updateHaki/$1');
$routes->post('deleteHaki/(:num)', 'HakiController::deleteHaki/$1');
$routes->get('/preview_pdf', 'PreviewPdfController::previewPdf');
