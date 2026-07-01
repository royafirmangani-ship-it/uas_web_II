<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?= site_url('dashboard') ?>" class="brand-link">
        <span class="brand-text font-weight-light">Sistem Klinik</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= site_url('dashboard') ?>" class="nav-link <?= $this->uri->segment(1) == 'dashboard' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <?php if ($this->session->userdata('role') == 'admin'): ?>
                <li class="nav-header">MASTER DATA</li>
                <?php endif; ?>

                <?php if ($this->session->userdata('role') == 'admin'): ?>
                <li class="nav-item">
                    <a href="<?= site_url('user') ?>" class="nav-link <?= $this->uri->segment(1) == 'user' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>User</p>
                    </a>
                </li>
                <?php endif; ?>

                <li class="nav-item has-treeview <?= in_array($this->uri->segment(1), ['pasien', 'dokter', 'poli', 'obat']) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= in_array($this->uri->segment(1), ['pasien', 'dokter', 'poli', 'obat']) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-database"></i>
                        <p>Master Data<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('pasien') ?>" class="nav-link <?= $this->uri->segment(1) == 'pasien' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-user-injured"></i>
                                <p>Pasien</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('dokter') ?>" class="nav-link <?= $this->uri->segment(1) == 'dokter' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-user-md"></i>
                                <p>Dokter</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('poli') ?>" class="nav-link <?= $this->uri->segment(1) == 'poli' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-hospital"></i>
                                <p>Poli</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('obat') ?>" class="nav-link <?= $this->uri->segment(1) == 'obat' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-capsules"></i>
                                <p>Obat</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">TRANSAKSI</li>

                <li class="nav-item has-treeview <?= in_array($this->uri->segment(1), ['pendaftaran', 'pemeriksaan', 'resep', 'pembayaran']) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= in_array($this->uri->segment(1), ['pendaftaran', 'pemeriksaan', 'resep', 'pembayaran']) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-exchange-alt"></i>
                        <p>Transaksi<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('pendaftaran') ?>" class="nav-link <?= $this->uri->segment(1) == 'pendaftaran' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>Pendaftaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('pemeriksaan') ?>" class="nav-link <?= $this->uri->segment(1) == 'pemeriksaan' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-stethoscope"></i>
                                <p>Pemeriksaan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('resep') ?>" class="nav-link <?= $this->uri->segment(1) == 'resep' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-prescription"></i>
                                <p>Resep</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('pembayaran') ?>" class="nav-link <?= $this->uri->segment(1) == 'pembayaran' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-money-bill-wave"></i>
                                <p>Pembayaran</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">LAPORAN</li>

                <li class="nav-item has-treeview <?= ($this->uri->segment(1) == 'laporan') ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= ($this->uri->segment(1) == 'laporan') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Laporan<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('laporan/pasien') ?>" class="nav-link <?= ($this->uri->segment(1) == 'laporan' && $this->uri->segment(2) == 'pasien') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Pasien</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('laporan/pemeriksaan') ?>" class="nav-link <?= ($this->uri->segment(1) == 'laporan' && $this->uri->segment(2) == 'pemeriksaan') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-file-medical"></i>
                                <p>Pemeriksaan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('laporan/pembayaran') ?>" class="nav-link <?= ($this->uri->segment(1) == 'laporan' && $this->uri->segment(2) == 'pembayaran') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-file-invoice"></i>
                                <p>Pembayaran</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="<?= site_url('auth/logout') ?>" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
