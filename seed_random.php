<?php
    $connection = mysqli_connect("localhost","root","");
    $db = mysqli_select_db($connection,"lms");
    $log = [];
    $seedCount = isset($_GET['n']) ? max(1, min(200, intval($_GET['n']))) : 25;

    // ── RANDOM DATA POOLS ──
    $nepaliFirstNames = [
        "Aarav", "Aarya", "Abhinna", "Aditi", "Anish", "Ankit", "Ankit", "Annapurna", "Anshu", "Anubhav",
        "Apsara", "Arati", "Arun", "Asha", "Ashish", "Asmita", "Babu", "Bajra", "Basanta", "Bhairav",
        "Bhanu", "Bhawana", "Bhuwan", "Bibek", "Bibha", "Bikash", "Bikram", "Bimal", "Bina", "Bishal",
        "Bishnu", "Bishwas", "Buddha", "Chandra", "Damodar", "Deepa", "Deepak", "Devi", "Dharma", "Dhiraj",
        "Dhruba", "Dipak", "Diya", "Durga", "Ganesh", "Gauri", "Geeta", "Gita", "Gopal", "Gopi",
        "Hari", "Harish", "Hema", "Himani", "Indira", "Ishwar", "Jagannath", "Jamuna", "Janak", "Jasmine",
        "Jayanti", "Jeevan", "Jhalak", "Kabita", "Kalyan", "Kamala", "Kanchha", "Kapil", "Karna", "Karuna",
        "Kashi", "Keshab", "Khadga", "Khem", "Kiran", "Kishor", "Krishna", "Kumari", "Lalita", "Laxman",
        "Laxmi", "Lila", "Madan", "Madhav", "Madhuri", "Mahesh", "Mani", "Manish", "Manju", "Manoj",
        "Meena", "Menuka", "Mira", "Mohan", "Motilal", "Mukesh", "Nabina", "Nanda", "Narayan", "Naresh",
        "Nirmala", "Nisha", "Nita", "Om", "Padma", "Pawan", "Phulmaya", "Prabin", "Pradeep", "Prakash",
        "Pramila", "Pratap", "Prem", "Purna", "Pushpa", "Rabin", "Radha", "Raju", "Rakesh", "Rama",
        "Ramesh", "Ranjana", "Ranjit", "Ravi", "Rekha", "Rina", "Ritesh", "Rohit", "Sabina", "Sabitri",
        "Sachin", "Sagar", "Sahana", "Sajan", "Sakuntala", "Salina", "Samir", "Sandesh", "Sandhya", "Sangita",
        "Sanjay", "Santosh", "Sarita", "Sarmila", "Saroj", "Saurav", "Shakti", "Shambhu", "Shankar", "Shanti",
        "Sharada", "Shiva", "Shovana", "Shree", "Shreeram", "Shyam", "Siddhartha", "Sita", "Sneha", "Sobha",
        "Subarna", "Subash", "Subha", "Sudan", "Sudeep", "Sujata", "Suman", "Sunil", "Sunita", "Surya",
        "Sushma", "Tara", "Tej", "Thakur", "Tika", "Tulasi", "Uma", "Umesh", "Urmila", "Vidya"
    ];
    $nepaliLastNames = [
        "Sharma", "Adhikari", "KC", "Pradhan", "Tamang", "Sherpa", "Lama", "Rai", "Limbu", "Magar",
        "Thapa", "Gurung", "Maharjan", "Shrestha", "Bajracharya", "Joshi", "Pandey", "Dahal", "Khadka",
        "Bohara", "Aryal", "Subedi", "Poudel", "Karki", "Basnet", "Dongol", "Mahat", "Rana", "Singh",
        "Yadav", "Sah", "Jha", "Mishra", "Tiwari", "Bhatta", "Pant", "Bhatt", "Kafle", "Acharya",
        "Dhungel", "Manandhar", "Dangol", "Tuladhar", "Munankarmi", "Nakarmi", "Syangtan", "Lungeli", "Moktan", "Tamu",
        "Bhujel", "Khatri", "Chhetri", "Kunwar", "Thakuri", "Bhandari", "Dulal", "Lohani", "Pathak", "Sigdel"
    ];
    $nepaliCities = [
        "Kathmandu", "Pokhara", "Lalitpur", "Bhaktapur", "Biratnagar", "Birgunj", "Butwal", "Dharan", "Bharatpur",
        "Janakpur", "Hetauda", "Nepalgunj", "Itahari", "Dhangadi", "Mahendranagar", "Siddharthanagar", "Tulsipur",
        "Bhimdatta", "Lahan", "Inaruwa", "Damak", "Birtamod", "Khandbari", "Gorkha", "Tanahun", "Chitwan",
        "Palpa", "Syangja", "Myagdi", "Baglung", "Parbat", "Mustang", "Manang", "Jumla", "Dolpa", "Mugu",
        "Humla", "Kalikot", "Jajarkot", "Rukum", "Salyan", "Rolpa", "Pyuthan", "Dang", "Banke", "Bardiya",
        "Surkhet", "Dailekh", "Achham", "Doti", "Bajura", "Bajhang", "Darchula"
    ];
    $nepaliTowns = [
        "New Baneshwor", "Boudha", "Thamel", "Lazimpat", "Dillibazar", "Putalisadak", "Kamaladi", "Naxal",
        "Maharajgunj", "Balkhu", "Ekantakuna", "Kalanki", "Bafal", "Swayambhu", "Sitapaila", "Balaju",
        "Gongabu", "Samakhushi", "Chabahil", "Gaushala", "Patan Dhoka", "Mangal Bazar", "Kupondole",
        "Jhamsikhel", "Sanepa", "Balkumari", "Bagdol", "Satdobato", "Imadol", "Gwarko", "Koteshwor",
        "Tinkune", "Sinamangal", "Airport", "Gaushala", "Bishnumati", "Balaju", "Swayambhu", "Ratna Park"
    ];

    // ── 1. AUTHORS (always add) ──
    $nepaliAuthors = [
        "Laxmi Prasad Devkota", "Parijat", "B.P. Koirala", "Amar Singh Thapa", "Dharanidhar Dahal",
        "Gopal Prasad Rimal", "Bishweshwar Prasad Koirala", "Indra Bahadur Rai", "Pashupati Sharma Giri",
        "Madan Bhandari", "Shiva Kumar Rai", "Raju Thapa", "Bhuwan Thapa", "Anuradha Sharma",
        "Diwakar Jung Bahadur Rana", "Harihar Sharma", "Tek Bir Lohani", "Keshav Dahal",
        "Shyam Goenka", "Indra Lal Sharma", "Bhola Bikram KC", "Yamuna Karki", "Dambar Bahadur Bista"
    ];
    $allAuthors = $nepaliAuthors;
    $newAuthors = array_slice($nepaliAuthors, 0, min($seedCount, count($nepaliAuthors)));
    $insertedAuthors = 0;
    foreach ($newAuthors as $a) {
        $esc = mysqli_real_escape_string($connection, $a);
        if (mysqli_query($connection, "INSERT INTO authors (author_name) VALUES ('$esc')")) {
            $insertedAuthors++;
        }
    }
    $log[] = ["Added $insertedAuthors new authors (Nepali literary figures).", "ok"];

    // ── 2. CATEGORIES (always add) ──
    $nepaliCategories = [
        "Nepali Literature", "Hindi Literature", "English Literature", "Religious Texts",
        "Cookbooks", "Comics & Manga", "Magazines", "Dictionaries", "Encyclopedias",
        "Research Papers", "Law & Constitution", "Medical & Health", "Engineering",
        "Mathematics", "Economics", "Politics", "Sociology", "Psychology", "Geography",
        "Environment & Ecology", "Sports", "Music & Performing Arts", "Photography",
        "Architecture", "Fashion", "Food & Wine", "Gardening", "Pets & Animals",
        "Automotive", "Real Estate", "Finance & Investment", "Career Development",
        "Relationships", "Parenting", "Spirituality", "Meditation", "Astrology",
        "Travel Guides", "Cultural Studies", "Linguistics", "Translation Studies"
    ];
    $newCategories = array_slice($nepaliCategories, 0, min($seedCount, count($nepaliCategories)));
    $insertedCats = 0;
    foreach ($newCategories as $c) {
        $esc = mysqli_real_escape_string($connection, $c);
        if (mysqli_query($connection, "INSERT INTO category (cat_name) VALUES ('$esc')")) {
            $insertedCats++;
        }
    }
    $log[] = ["Added $insertedCats new categories.", "ok"];

    // ── 3. BOOKS (always add) ──
    $bookTemplates = [
        "The Art of {noun}", "Mastering {noun}", "A Guide to {noun}", "{noun} Essentials",
        "Complete {noun}", "Introduction to {noun}", "Advanced {noun}", "{noun} in Practice",
        "Principles of {noun}", "Understanding {noun}", "The {noun} Handbook", "Modern {noun}",
        "Exploring {noun}", "{noun} for Beginners", "The Science of {noun}"
    ];
    $bookNouns = [
        "Mountains", "Rivers", "Monsoon", "Himalayas", "Terai", "Hills", "Valleys", "Forests",
        "Festivals", "Traditions", "Cuisines", "Music", "Dance", "Art", "Crafts", "Architecture",
        "Temples", "Stupas", "Monasteries", "Cities", "Villages", "Heritage", "Folktales", "Legends",
        "Mythology", "Spirituality", "Meditation", "Yoga", "Ayurveda", "Tea", "Coffee", "Spices",
        "Mountaineering", "Trekking", "Adventure", "Wildlife", "Birds", "Flowers", "Gardens"
    ];
    $totalBooksBefore = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as c FROM books"))['c'];
    $totalAuthors = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as c FROM authors"))['c'];
    $totalCats = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as c FROM category"))['c'];

    $insertedBooks = 0;
    for ($i = 0; $i < $seedCount; $i++) {
        $tpl = $bookTemplates[array_rand($bookTemplates)];
        $noun = $bookNouns[array_rand($bookNouns)];
        $title = str_replace('{noun}', $noun, $tpl);
        $authorId = ($totalAuthors > 0) ? rand(1, $totalAuthors) : 1;
        $catId = ($totalCats > 0) ? rand(1, $totalCats) : 1;
        $isbn = "978-" . str_pad(rand(0, 9999999999), 10, "0", STR_PAD_LEFT);
        $price = rand(299, 2500) + (rand(0, 99) / 100);

        $titleEsc = mysqli_real_escape_string($connection, $title);
        $isbnEsc = mysqli_real_escape_string($connection, $isbn);
        if (mysqli_query($connection, sprintf(
            "INSERT INTO books (book_name, author_id, cat_id, book_no, book_price) VALUES ('%s', %d, %d, '%s', %.2f)",
            $titleEsc, $authorId, $catId, $isbnEsc, $price
        ))) {
            $insertedBooks++;
        }
    }
    $log[] = ["Added $insertedBooks new books (random titles, ISBN, NPR prices).", "ok"];

    // ── 4. USERS (always add) ──
    $insertedUsers = 0;
    for ($i = 0; $i < $seedCount; $i++) {
        $first = $nepaliFirstNames[array_rand($nepaliFirstNames)];
        $last = $nepaliLastNames[array_rand($nepaliLastNames)];
        $name = "$first $last";
        $email = strtolower($first) . strtolower($last) . rand(10, 99) . "@aurora.library.np";
        $email = str_replace(' ', '', $email);
        $password = "pass" . rand(100, 999);
        $mobile = "98" . str_pad(rand(0, 99999999), 8, "0", STR_PAD_LEFT);
        $city = $nepaliCities[array_rand($nepaliCities)];
        $town = $nepaliTowns[array_rand($nepaliTowns)];
        $address = $town . ", " . $city;

        $nameEsc = mysqli_real_escape_string($connection, $name);
        $emailEsc = mysqli_real_escape_string($connection, $email);
        $passEsc = mysqli_real_escape_string($connection, $password);
        $addrEsc = mysqli_real_escape_string($connection, $address);

        if (mysqli_query($connection, sprintf(
            "INSERT INTO users (name, email, password, mobile, address) VALUES ('%s', '%s', '%s', %d, '%s')",
            $nameEsc, $emailEsc, $passEsc, (int)$mobile, $addrEsc
        ))) {
            $insertedUsers++;
        }
    }
    $log[] = ["Added $insertedUsers new members (Nepali names, @aurora.library.np emails).", "ok"];

    // ── 5. ISSUED BOOKS (always add) ──
    $totalUsersAfter = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as c FROM users"))['c'];
    $totalBooksAfter = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as c FROM books"))['c'];
    $issuedCount = 0;
    for ($i = 0; $i < $seedCount; $i++) {
        $studentId = ($totalUsersAfter > 0) ? rand(1, $totalUsersAfter) : 1;
        $bookNo = rand(1, max(1, $totalBooksAfter));
        $bookName = "Sample Book #$bookNo";
        $author = "Author " . rand(1, max(1, $totalAuthors));
        $status = (rand(1, 100) <= 80) ? 1 : 0;
        $daysAgo = rand(1, 60);
        $issueDate = date('Y-m-d', strtotime("-$daysAgo days"));

        $bookNameEsc = mysqli_real_escape_string($connection, $bookName);
        $authorEsc = mysqli_real_escape_string($connection, $author);
        if (mysqli_query($connection, sprintf(
            "INSERT INTO issued_books (book_no, book_name, book_author, student_id, status, issue_date) VALUES ('%s', '%s', '%s', %d, %d, '%s')",
            $bookNo, $bookNameEsc, $authorEsc, $studentId, $status, $issueDate
        ))) {
            $issuedCount++;
        }
    }
    $log[] = ["Added $issuedCount new issued-book records (80% active, 20% returned).", "ok"];

    // ── SUMMARY ──
    $totals = [
        'authors' => mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as c FROM authors"))['c'],
        'categories' => mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as c FROM category"))['c'],
        'books' => mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as c FROM books"))['c'],
        'users' => mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as c FROM users"))['c'],
        'issued_books' => mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as c FROM issued_books"))['c'],
    ];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Random Seed · Aurora Library</title>
    <link rel="stylesheet" href="static/css/aurora.css">
</head>
<body class="app-bg" style="display:flex;align-items:center;justify-content:center;min-height:100vh;padding:24px;">
    <div class="auth__card fade-up" style="max-width:600px;width:100%;">
        <div class="flex" style="align-items:center;gap:14px;margin-bottom:24px;">
            <div style="width:48px;height:48px;border-radius:12px;background:linear-gradient(135deg,var(--emerald),#0f4d2c);display:grid;place-items:center;flex-shrink:0;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
            </div>
            <div>
                <h2 class="auth__title" style="font-size:26px;margin:0;">Random data added.</h2>
                <p class="auth__subtitle" style="margin:2px 0 0;font-size:13px;"><?php echo $seedCount; ?> new records per table — all Nepali-flavored</p>
            </div>
        </div>

        <div style="background:var(--ink-50);border:1px solid var(--ink-100);border-radius:14px;padding:16px 20px;margin-bottom:20px;">
            <div style="display:grid;gap:8px;">
                <?php foreach($log as $entry): ?>
                    <div class="flex gap-2" style="align-items:center;font-size:13px;">
                        <span style="color:var(--emerald);font-weight:700;">✓</span>
                        <span><?php echo $entry[0]; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px;">
            <div style="text-align:center;padding:16px;background:linear-gradient(135deg,var(--ink-50),var(--cream));border-radius:14px;border:1px solid var(--ink-100);">
                <div style="font-family:'Playfair Display',serif;font-size:28px;font-weight:600;color:var(--ink-900);"><?php echo $totals['authors']; ?></div>
                <div style="font-size:11px;color:var(--ink-500);text-transform:uppercase;letter-spacing:0.1em;">Authors</div>
            </div>
            <div style="text-align:center;padding:16px;background:linear-gradient(135deg,var(--ink-50),var(--cream));border-radius:14px;border:1px solid var(--ink-100);">
                <div style="font-family:'Playfair Display',serif;font-size:28px;font-weight:600;color:var(--ink-900);"><?php echo $totals['categories']; ?></div>
                <div style="font-size:11px;color:var(--ink-500);text-transform:uppercase;letter-spacing:0.1em;">Categories</div>
            </div>
            <div style="text-align:center;padding:16px;background:linear-gradient(135deg,var(--ink-50),var(--cream));border-radius:14px;border:1px solid var(--ink-100);">
                <div style="font-family:'Playfair Display',serif;font-size:28px;font-weight:600;color:var(--ink-900);"><?php echo $totals['books']; ?></div>
                <div style="font-size:11px;color:var(--ink-500);text-transform:uppercase;letter-spacing:0.1em;">Books</div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px;margin-bottom:24px;">
            <div style="text-align:center;padding:16px;background:linear-gradient(135deg,var(--ink-50),var(--cream));border-radius:14px;border:1px solid var(--ink-100);">
                <div style="font-family:'Playfair Display',serif;font-size:28px;font-weight:600;color:var(--ink-900);"><?php echo $totals['users']; ?></div>
                <div style="font-size:11px;color:var(--ink-500);text-transform:uppercase;letter-spacing:0.1em;">Members</div>
            </div>
            <div style="text-align:center;padding:16px;background:linear-gradient(135deg,var(--ink-50),var(--cream));border-radius:14px;border:1px solid var(--ink-100);">
                <div style="font-family:'Playfair Display',serif;font-size:28px;font-weight:600;color:var(--ink-900);"><?php echo $totals['issued_books']; ?></div>
                <div style="font-size:11px;color:var(--ink-500);text-transform:uppercase;letter-spacing:0.1em;">Issued Books</div>
            </div>
        </div>

        <div style="background:linear-gradient(135deg,#0a0e1a,#1f2937);border-radius:14px;padding:18px;margin-bottom:20px;">
            <div style="font-size:11px;color:var(--gold-400);text-transform:uppercase;letter-spacing:0.16em;font-weight:600;margin-bottom:10px;">Sample Login Credentials</div>
            <div style="display:grid;gap:6px;font-family:'JetBrains Mono',monospace;font-size:13px;color:rgba(255,255,255,0.85);">
                <div><span style="color:rgba(255,255,255,0.5);">Admin:</span> <strong style="color:#fff;">admin@aurora.library</strong> / <strong style="color:#fff;">admin123</strong></div>
                <div><span style="color:rgba(255,255,255,0.5);">Members:</span> <strong style="color:#fff;">*@aurora.library.np</strong> / <strong style="color:#fff;">pass###</strong> (random)</div>
            </div>
        </div>

        <div class="flex gap-3" style="justify-content:center;flex-wrap:wrap;">
            <a href="seed_random.php?n=50" class="btn btn--primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
                <span>Seed 50 More</span>
            </a>
            <a href="seed_random.php?n=100" class="btn btn--gold">Seed 100 More</a>
            <a href="Admin_Dashboard_Module/admin_dashboard.php" class="btn btn--ghost">Dashboard</a>
        </div>

        <p class="text-sm text-muted mt-6 text-center">
            Re-run any time — data is always appended, never duplicated. Pass <code style="background:var(--ink-100);padding:2px 6px;border-radius:4px;">?n=N</code> in the URL to control batch size (1–200).
        </p>
    </div>
</body>
</html>

