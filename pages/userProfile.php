<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Ecomomentum</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50">
    <div class="container mx-auto px-4 py-8">
        <!-- User Info Section -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-6">
            <h1 class="text-3xl font-bold text-green-700 mb-2">
                Welcome, <?php echo htmlspecialchars($userDetails['username']); ?>
            </h1>
            <p class="text-gray-600">
                <?php echo htmlspecialchars($userDetails['email']); ?>
            </p>
        </div>

        <!-- Profile Sections -->
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Climate Actions Section -->
            <section class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold text-green-700 mb-4">Your Climate Actions</h2>
                <?php if (!empty($climateActions)): ?>
                    <?php foreach ($climateActions as $action): ?>
                        <div class="bg-green-50 p-4 rounded-md mb-3 border-l-4 border-green-500">
                            <p class="text-gray-700">
                                <?php echo htmlspecialchars($action['action_description']); ?>
                            </p>
                            <small class="text-gray-500">
                                <?php echo htmlspecialchars($action['action_date']); ?>
                            </small>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500">No climate actions recorded yet.</p>
                <?php endif; ?>
            </section>

            <!-- Recommendations Section -->
            <section class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold text-green-700 mb-4">Recommendations</h2>
                <?php if (!empty($recommendations)): ?>
                    <?php foreach ($recommendations as $recommendation): ?>
                        <div class="bg-blue-50 p-4 rounded-md mb-3 border-l-4 border-blue-500">
                            <p class="text-gray-700">
                                <?php echo htmlspecialchars($recommendation); ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500">No personalized recommendations at the moment.</p>
                <?php endif; ?>
            </section>
        </div>
    </div>
</body>
</html>
