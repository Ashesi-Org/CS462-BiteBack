<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Ecomomentum</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50">
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-4xl font-bold mb-8 text-green-700 text-center">Admin Dashboard</h1>

        <!-- User and Resource Statistics Section -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
            <!-- User Stats Card -->
            <section class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-green-700 mb-4">User Statistics</h2>
                <div class="space-y-4">
                    <div class="flex justify-between border-b pb-2">
                        <span>Total Users</span>
                        <span class="font-bold text-green-600"><?php echo $userStats['total_users']; ?></span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span>Admin Users</span>
                        <span class="font-bold text-green-600"><?php echo $userStats['admin_users']; ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Regular Users</span>
                        <span class="font-bold text-green-600"><?php echo $userStats['regular_users']; ?></span>
                    </div>
                </div>
            </section>

            <!-- Resource Stats Card -->
            <section class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-green-700 mb-4">Resource Statistics</h2>
                <div class="space-y-4">
                    <div class="flex justify-between border-b pb-2">
                        <span>Total Resources</span>
                        <span class="font-bold text-green-600"><?php echo $resourceStats['total_resources']; ?></span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span>Articles</span>
                        <span class="font-bold text-green-600"><?php echo $resourceStats['articles']; ?></span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span>Videos</span>
                        <span class="font-bold text-green-600"><?php echo $resourceStats['videos']; ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Infographics</span>
                        <span class="font-bold text-green-600"><?php echo $resourceStats['infographics']; ?></span>
                    </div>
                </div>
            </section>

            <!-- Additional Cards or Sections can go here -->
        </div>

        <!-- Recent Activities Section -->
        <section class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-semibold text-green-700 mb-4">Recent Activities</h2>
            <?php if (!empty($recentActivities)): ?>
                <?php foreach ($recentActivities as $activity): ?>
                    <div class="bg-green-50 p-4 rounded-md mb-4 border-l-4 border-green-500">
                        <p class="text-gray-700">
                            <?php echo htmlspecialchars($activity['activity_description']); ?>
                        </p>
                        <small class="text-gray-500">
                            <?php echo htmlspecialchars($activity['activity_date']); ?>
                        </small>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500">No recent activities.</p>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>
