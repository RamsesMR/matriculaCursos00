<div class="progress-logo-container">
    <!-- Logo centrado encima del progreso -->
    <div class="logo-container text-center">
        <img src="imgs/logo.png" alt="Logo" />
    </div>

    <!-- Progreso de los pasos -->
    <div class="progress-container">
        <div class="step-circle <?php echo ($currentStep >= 1) ? 'completed' : ''; ?>">
            <?php echo ($currentStep >= 1) ? '<a href="index.php">1</a>' : '1'; ?>
        </div>
        <div class="step-line"></div>
        <div class="step-circle <?php echo ($currentStep >= 2) ? 'completed' : ''; ?>">
            <?php echo ($currentStep >= 2) ? '<a href="paso2.php">2</a>' : '2'; ?>
        </div>
        <div class="step-line"></div>
        <div class="step-circle <?php echo ($currentStep >= 3) ? 'completed' : ''; ?>">
            <?php echo ($currentStep >= 3) ? '<a href="paso3.php">3</a>' : '3'; ?>
        </div>
        <div class="step-line"></div>
        <div class="step-circle <?php echo ($currentStep >= 4) ? 'completed' : ''; ?>">
            <?php echo ($currentStep >= 4) ? '<a href="paso4.php">4</a>' : '4'; ?>
        </div>
        <div class="step-line"></div>
        <div class="step-circle <?php echo ($currentStep >= 5) ? 'completed' : ''; ?>">
            <?php echo ($currentStep >= 5) ? '<a href="paso5.php">5</a>' : '5'; ?>
        </div>
    </div>
</div>
