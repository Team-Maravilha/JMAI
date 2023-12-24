<div id="kt_app_toolbar" class="app-toolbar">
	<div class="d-flex flex-stack flex-row-fluid">
		<div class="d-flex flex-column flex-row-fluid">
			<ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-3">
				<li class="breadcrumb-item text-gray-600 fw-bold lh-1">
					<a href="/index.php" class="text-white text-hover-primary">
						<i class="ki-duotone ki-home text-gray-500 fs-2"></i>
					</a>
				</li>
				<li class="breadcrumb-item">
					<i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i>
				</li>
				<li class="breadcrumb-item text-gray-600 fw-bold lh-1">Dashboard</li>

				<?php 
				$request_uri = $_SERVER['REQUEST_URI'];
				$path = explode('/', $request_uri);
				array_pop($path);
				foreach ($path as $key => $value) {
					if ($key < 3) {
						continue;
					}

					//SEARCH IN BREADCRUMBS
					$found = false;

					$breadcrumb = array_filter($breadcrumbs, function ($item) use ($value) {
						return $item['path'] == $value && $item['role'] == $_SESSION['role'];
					});

					if (count($breadcrumb) > 0) {
						$found = true;
						$breadcrumb = array_values($breadcrumb)[0];
					}

					if($value != "" && $value != "index.php")
						echo '<li class="breadcrumb-item"><i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li><li class="breadcrumb-item text-gray-600 fw-bold lh-1">' . ($found && $breadcrumb['clickable'] ? '<a href="' . $breadcrumb['link'] . '" class="text-gray-600">' . $breadcrumb['name'] . '</a>' : ($found ? $breadcrumb['name'] : $value)) . '</li>';

				}
				?>
			</ul>
			<div class="page-title d-flex align-items-center me-3">
				<h1 class="page-heading d-flex text-gray-900 fw-bolder fs-1 flex-column justify-content-center my-0"><?php echo isset($page_name) ? $page_name : "JMAI" ?></h1>
			</div>
		</div>
		<!-- <div class="d-flex align-items-center gap-3 gap-lg-5">
			<a href="#" class="btn btn-flex btn-center bg-gray-600 btn-color-white h-35px h-md-40px btn-active-dark btn-sm px-6" data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends">
				<i class="ki-duotone ki-plus-square fs-2 p-0 m-0">
					<span class="path1"></span>
					<span class="path2"></span>
					<span class="path3"></span>
				</i>
				<span class="ms-2">Adicionar</span>
			</a>
		</div> -->
	</div>
</div>