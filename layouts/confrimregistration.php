<div class="confrim-registration-container">
	<form action="validation_registration.php" method="POST">
		<div class="row mb-2">
			<label for="confrim-code" class="col-md-4 col-form-label">Код подтверждения</label>
			<div class="col-md-8">
				<input type="text" class="form-control" name="confrim-code" placeholder="Confrim code" required>
			</div>
		</div>
		<div class="row mb-2">
			<label class="col-md-4 col-form-label p-0 m-0"></label>
			<div class="row col-md-8 justify-content-center">
				<button type="submit" class="btn btn-primary w-50" name="confrim">Подтвердить</button>
			</div>
		</div>
	</form>
</div>