<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;



use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;



class CommunitySeeder extends Seeder
{
    public function run(): void
    {

        $communities = [
            //hindu
            ['name' => "24 Manai Telugu Chettiar", 'religion_id' => 1],
            ['name' => "96 Kuli Maratha", 'religion_id' => 1],
            ['name' => "96K Kokanastha", 'religion_id' => 1],
            ['name' => "Adi Andhra", 'religion_id' => 1],
            ['name' => "Adi Dharmi", 'religion_id' => 1],
            ['name' => "Adi Dravida", 'religion_id' => 1],
            ['name' => "Adi Karnataka", 'religion_id' => 1],
            ['name' => "Agamudayar", 'religion_id' => 1],
            ['name' => "Agarwal", 'religion_id' => 1],
            ['name' => "Kshatriya - All", 'religion_id' => 1],
            ['name' => "Agnikula Kshatriya", 'religion_id' => 1],
            ['name' => "Agri", 'religion_id' => 1],
            ['name' => "Ahir", 'religion_id' => 1],
            ['name' => "Ahom", 'religion_id' => 1],
            ['name' => "Ambalavasi", 'religion_id' => 1],
            ['name' => "Arcot", 'religion_id' => 1],
            ['name' => "Arekatica", 'religion_id' => 1],
            ['name' => "Arora", 'religion_id' => 1],
            ['name' => "Arunthathiyar", 'religion_id' => 1],
            ['name' => "Aryasamaj", 'religion_id' => 1],
            ['name' => "Arya Vysya", 'religion_id' => 1],
            ['name' => "Ayyaraka", 'religion_id' => 1],
            ['name' => "Badaga", 'religion_id' => 1],
            ['name' => "Baghel/Pal/Gaderiya", 'religion_id' => 1],
            ['name' => "Bahi", 'religion_id' => 1],
            ['name' => "Baidya", 'religion_id' => 1],
            ['name' => "Baishnab", 'religion_id' => 1],
            ['name' => "Baishya", 'religion_id' => 1],
            ['name' => "Bajantri", 'religion_id' => 1],
            ['name' => "Balija", 'religion_id' => 1],
            ['name' => "Naidu - All", 'religion_id' => 1],
            ['name' => "Balija - Naidu", 'religion_id' => 1],
            ['name' => "Banayat Oriya", 'religion_id' => 1],
            ['name' => "Banik", 'religion_id' => 1],
            ['name' => "Baniya", 'religion_id' => 1],
            ['name' => "Barai", 'religion_id' => 1],
            ['name' => "Bari", 'religion_id' => 1],
            ['name' => "Barnwal", 'religion_id' => 1],
            ['name' => "Barujibi", 'religion_id' => 1],
            ['name' => "Bengali", 'religion_id' => 1],
            ['name' => "Besta", 'religion_id' => 1],
            ['name' => "Bhandari", 'religion_id' => 1],
            ['name' => "Bhatia", 'religion_id' => 1],
            ['name' => "Bhatraju", 'religion_id' => 1],
            ['name' => "Bhavsar", 'religion_id' => 1],
            ['name' => "Bhovi", 'religion_id' => 1],
            ['name' => "Billava", 'religion_id' => 1],
            ['name' => "Boya/Nayak/Naik", 'religion_id' => 1],
            ['name' => "Boyer", 'religion_id' => 1],
            ['name' => "Brahmbatt", 'religion_id' => 1],
            ['name' => "Brahmin - All", 'religion_id' => 1],
            ['name' => "Brahmin", 'religion_id' => 1],
            ['name' => "Brahmin - Anavil", 'religion_id' => 1],
            ['name' => "Brahmin - Audichya", 'religion_id' => 1],
            ['name' => "Brahmin - Barendra", 'religion_id' => 1],
            ['name' => "Brahmin - Bengali", 'religion_id' => 1],
            ['name' => "Brahmin - Bhatt", 'religion_id' => 1],
            ['name' => "Brahmin - Bhumihar", 'religion_id' => 1],
            ['name' => "Brahmin - Brahmbhatt", 'religion_id' => 1],
            ['name' => "Brahmin - Dadhich/Dadheech", 'religion_id' => 1],
            ['name' => "Brahmin - Daivadnya", 'religion_id' => 1],
            ['name' => "Brahmin - Danua", 'religion_id' => 1],
            ['name' => "Brahmin - Deshastha", 'religion_id' => 1],
            ['name' => "Brahmin - Dhiman", 'religion_id' => 1],
            ['name' => "Brahmin - Dravida", 'religion_id' => 1],
            ['name' => "Brahmin - Embrandiri", 'religion_id' => 1],
            ['name' => "Brahmin - Garhwali", 'religion_id' => 1],
            ['name' => "Brahmin - Goswami", 'religion_id' => 1],
            ['name' => "Brahmin - Gour", 'religion_id' => 1],
            ['name' => "Brahmin - Gowd Saraswat", 'religion_id' => 1],
            ['name' => "Brahmin - Gujar Gour", 'religion_id' => 1],
            ['name' => "Brahmin - Gurukkal", 'religion_id' => 1],
            ['name' => "Brahmin - Halua", 'religion_id' => 1],
            ['name' => "Brahmin - Havyaka", 'religion_id' => 1],
            ['name' => "Brahmin - Himachali", 'religion_id' => 1],
            ['name' => "Brahmin - Hoysala", 'religion_id' => 1],
            ['name' => "Brahmin - Iyengar", 'religion_id' => 1],
            ['name' => "Brahmin - Iyer", 'religion_id' => 1],
            ['name' => "Brahmin - Jangid", 'religion_id' => 1],
            ['name' => "Brahmin - Jhadua", 'religion_id' => 1],
            ['name' => "Brahmin - Jhijhotiya", 'religion_id' => 1],
            ['name' => "Brahmin - Kannada Madhva", 'religion_id' => 1],
            ['name' => "Brahmin - Kanyakubja", 'religion_id' => 1],
            ['name' => "Brahmin - Karhade", 'religion_id' => 1],
            ['name' => "Brahmin - Kashmiri Pandit", 'religion_id' => 1],
            ['name' => "Brahmin - Kokanastha", 'religion_id' => 1],
            ['name' => "Brahmin - Kota", 'religion_id' => 1],
            ['name' => "Brahmin - Kulin", 'religion_id' => 1],
            ['name' => "Brahmin - Kumaoni", 'religion_id' => 1],
            ['name' => "Brahmin - Madhwa", 'religion_id' => 1],
            ['name' => "Brahmin - Maharashtrian", 'religion_id' => 1],
            ['name' => "Brahmin - Maithili", 'religion_id' => 1],
            ['name' => "Brahmin - Modh", 'religion_id' => 1],
            ['name' => "Brahmin - Mohyal", 'religion_id' => 1],
            ['name' => "Brahmin - Nagar", 'religion_id' => 1],
            ['name' => "Brahmin - Namboodiri", 'religion_id' => 1],
            ['name' => "Brahmin - Niyogi", 'religion_id' => 1],
            ['name' => "Brahmin - Niyogi Nandavariki", 'religion_id' => 1],
            ['name' => "Brahmin - Other", 'religion_id' => 1],
            ['name' => "Brahmin - Paliwal", 'religion_id' => 1],
            ['name' => "Brahmin - Panda", 'religion_id' => 1],
            ['name' => "Brahmin - Pareek", 'religion_id' => 1],
            ['name' => "Brahmin - Punjabi", 'religion_id' => 1],
            ['name' => "Brahmin - Pushkarna", 'religion_id' => 1],
            ['name' => "Brahmin - Rarhi", 'religion_id' => 1],
            ['name' => "Brahmin - Rudraj", 'religion_id' => 1],
            ['name' => "Brahmin - Sakaldwipi", 'religion_id' => 1],
            ['name' => "Brahmin - Sanadya", 'religion_id' => 1],
            ['name' => "Brahmin - Sanketi", 'religion_id' => 1],
            ['name' => "Brahmin - Saraswat", 'religion_id' => 1],
            ['name' => "Brahmin - Sarua", 'religion_id' => 1],
            ['name' => "Brahmin - Saryuparin", 'religion_id' => 1],
            ['name' => "Brahmin - Shivhalli", 'religion_id' => 1],
            ['name' => "Brahmin - Shrimali", 'religion_id' => 1],
            ['name' => "Brahmin - Smartha", 'religion_id' => 1],
            ['name' => "Brahmin - Sri Vaishnava", 'religion_id' => 1],
            ['name' => "Brahmin - Stanika", 'religion_id' => 1],
            ['name' => "Brahmin - Tyagi", 'religion_id' => 1],
            ['name' => "Brahmin - Vaidiki", 'religion_id' => 1],
            ['name' => "Brahmin - Vaikhanasa", 'religion_id' => 1],
            ['name' => "Brahmin - Velanadu", 'religion_id' => 1],
            ['name' => "Brahmin - Viswabrahmin", 'religion_id' => 1],
            ['name' => "Brahmin - Vyas", 'religion_id' => 1],
            ['name' => "Brahmo", 'religion_id' => 1],
            ['name' => "Buddar", 'religion_id' => 1],
            ['name' => "Bunt (Shetty)", 'religion_id' => 1],
            ['name' => "CKP", 'religion_id' => 1],
            ['name' => "Chalawadi Holeya", 'religion_id' => 1],
            ['name' => "Chambhar", 'religion_id' => 1],
            ['name' => "Chandravanshi Kahar", 'religion_id' => 1],
            ['name' => "Chasa", 'religion_id' => 1],
            ['name' => "Chattada Sri Vaishnava", 'religion_id' => 1],
            ['name' => "Chaudary", 'religion_id' => 1],
            ['name' => "Chaurasia", 'religion_id' => 1],
            ['name' => "Chekkala - Nair", 'religion_id' => 1],
            ['name' => "Chennadasar", 'religion_id' => 1],
            ['name' => "Cheramar", 'religion_id' => 1],
            ['name' => "Chettiar", 'religion_id' => 1],
            ['name' => "Chhetri", 'religion_id' => 1],
            ['name' => "Chippolu/Mera", 'religion_id' => 1],
            ['name' => "Coorgi", 'religion_id' => 1],
            ['name' => "Devadiga", 'religion_id' => 1],
            ['name' => "Devanga", 'religion_id' => 1],
            ['name' => "Devar/Thevar/Mukkulathor", 'religion_id' => 1],
            ['name' => "Devendra Kula Vellalar", 'religion_id' => 1],
            ['name' => "Dhangar", 'religion_id' => 1],
            ['name' => "Dheevara", 'religion_id' => 1],
            ['name' => "Dhiman", 'religion_id' => 1],
            ['name' => "Dhoba", 'religion_id' => 1],
            ['name' => "Dhobi", 'religion_id' => 1],
            ['name' => "Digambar", 'religion_id' => 1],
            ['name' => "Dommala", 'religion_id' => 1],
            ['name' => "Dusadh", 'religion_id' => 1],
            ['name' => "Ediga", 'religion_id' => 1],
            ['name' => "Ezhava", 'religion_id' => 1],
            ['name' => "Ezhuthachan", 'religion_id' => 1],
            ['name' => "Gabit", 'religion_id' => 1],
            ['name' => "Ganakar", 'religion_id' => 1],
            ['name' => "Gandla", 'religion_id' => 1],
            ['name' => "Ganiga", 'religion_id' => 1],
            ['name' => "Garhwali", 'religion_id' => 1],
            ['name' => "Gatti", 'religion_id' => 1],
            ['name' => "Gavali", 'religion_id' => 1],
            ['name' => "Gavara", 'religion_id' => 1],
            ['name' => "Ghumar", 'religion_id' => 1],
            ['name' => "Goala", 'religion_id' => 1],
            ['name' => "Goan", 'religion_id' => 1],
            ['name' => "Goswami", 'religion_id' => 1],
            ['name' => "Goud", 'religion_id' => 1],
            ['name' => "Gounder", 'religion_id' => 1],
            ['name' => "Gowda", 'religion_id' => 1],
            ['name' => "Gramani", 'religion_id' => 1],
            ['name' => "Gudia", 'religion_id' => 1],
            ['name' => "Gujarati", 'religion_id' => 1],
            ['name' => "Gujjar", 'religion_id' => 1],
            ['name' => "Gupta", 'religion_id' => 1],
            ['name' => "Guptan", 'religion_id' => 1],
            ['name' => "Gurjar", 'religion_id' => 1],
            ['name' => "Halwai", 'religion_id' => 1],
            ['name' => "Hegde", 'religion_id' => 1],
            ['name' => "Helava", 'religion_id' => 1],
            ['name' => "Hugar (Jeer)", 'religion_id' => 1],
            ['name' => "Intercaste", 'religion_id' => 1],
            ['name' => "Jaalari", 'religion_id' => 1],
            ['name' => "Jaiswal", 'religion_id' => 1],
            ['name' => "Jandra", 'religion_id' => 1],
            ['name' => "Jangam", 'religion_id' => 1],
            ['name' => "Jat", 'religion_id' => 1],
            ['name' => "Jatav", 'religion_id' => 1],
            ['name' => "Jetty Malla", 'religion_id' => 1],
            ['name' => "Kachara", 'religion_id' => 1],
            ['name' => "Kaibarta", 'religion_id' => 1],
            ['name' => "Kakkalan", 'religion_id' => 1],
            ['name' => "Kalar", 'religion_id' => 1],
            ['name' => "Kalinga", 'religion_id' => 1],
            ['name' => "Kalinga Vysya", 'religion_id' => 1],
            ['name' => "Kalita", 'religion_id' => 1],
            ['name' => "Kalwar", 'religion_id' => 1],
            ['name' => "Kamboj", 'religion_id' => 1],
            ['name' => "Kamma", 'religion_id' => 1],
            ['name' => "Kamma Naidu", 'religion_id' => 1],
            ['name' => "Kammala", 'religion_id' => 1],
            ['name' => "Kaniyan", 'religion_id' => 1],
            ['name' => "Kannada Mogaveera", 'religion_id' => 1],
            ['name' => "Kansari", 'religion_id' => 1],
            ['name' => "Kanu", 'religion_id' => 1],
            ['name' => "Kapu", 'religion_id' => 1],
            ['name' => "Kapu Naidu", 'religion_id' => 1],
            ['name' => "Karana", 'religion_id' => 1],
            ['name' => "Karmakar", 'religion_id' => 1],
            ['name' => "Kartha", 'religion_id' => 1],
            ['name' => "Karuneegar", 'religion_id' => 1],
            ['name' => "Kasar", 'religion_id' => 1],
            ['name' => "Kashyap", 'religion_id' => 1],
            ['name' => "Kavuthiyya/Ezhavathy", 'religion_id' => 1],
            ['name' => "Kayastha", 'religion_id' => 1],
            ['name' => "Khandayat", 'religion_id' => 1],
            ['name' => "Khandelwal", 'religion_id' => 1],
            ['name' => "Kharwar", 'religion_id' => 1],
            ['name' => "Khatik", 'religion_id' => 1],
            ['name' => "Khatri", 'religion_id' => 1],
            ['name' => "Kirar", 'religion_id' => 1],
            ['name' => "Koli", 'religion_id' => 1],
            ['name' => "Koli Patel", 'religion_id' => 1],
            ['name' => "Kongu Vellala Gounder", 'religion_id' => 1],
            ['name' => "Konkani", 'religion_id' => 1],
            ['name' => "Korama", 'religion_id' => 1],
            ['name' => "Kori", 'religion_id' => 1],
            ['name' => "Koshti", 'religion_id' => 1],
            ['name' => "Krishnavaka", 'religion_id' => 1],
            ['name' => "Kshatriya", 'religion_id' => 1],
            ['name' => "Kshatriya - Bhavasar", 'religion_id' => 1],
            ['name' => "Kshatriya/Raju/Varma", 'religion_id' => 1],
            ['name' => "Kudumbi", 'religion_id' => 1],
            ['name' => "Kulal", 'religion_id' => 1],
            ['name' => "Kulalar", 'religion_id' => 1],
            ['name' => "Kulita", 'religion_id' => 1],
            ['name' => "Kumawat", 'religion_id' => 1],
            ['name' => "Kumbara", 'religion_id' => 1],
            ['name' => "Kumbhakar/Kumbhar", 'religion_id' => 1],
            ['name' => "Kumhar", 'religion_id' => 1],
            ['name' => "Kummari", 'religion_id' => 1],
            ['name' => "Kunbi", 'religion_id' => 1],
            ['name' => "Kurava", 'religion_id' => 1],
            ['name' => "Kuravan", 'religion_id' => 1],
            ['name' => "Kurmi", 'religion_id' => 1],
            ['name' => "Kurmi Kshatriya", 'religion_id' => 1],
            ['name' => "Kuruba", 'religion_id' => 1],
            ['name' => "Kuruhina Shetty", 'religion_id' => 1],
            ['name' => "Kurumbar", 'religion_id' => 1],
            ['name' => "Kurup", 'religion_id' => 1],
            ['name' => "Kushwaha", 'religion_id' => 1],
            ['name' => "Kutchi", 'religion_id' => 1],
            ['name' => "Lambadi/Banjara", 'religion_id' => 1],
            ['name' => "Lambani", 'religion_id' => 1],
            ['name' => "Leva Patil", 'religion_id' => 1],
            ['name' => "Lingayath", 'religion_id' => 1],
            ['name' => "Lohana", 'religion_id' => 1],
            ['name' => "Lohar", 'religion_id' => 1],
            ['name' => "Loniya/Lonia/Lunia", 'religion_id' => 1],
            ['name' => "Lubana", 'religion_id' => 1],
            ['name' => "Madhesiya", 'religion_id' => 1],
            ['name' => "Madiga", 'religion_id' => 1],
            ['name' => "Mahajan", 'religion_id' => 1],
            ['name' => "Mahar", 'religion_id' => 1],
            ['name' => "Maharashtrian", 'religion_id' => 1],
            ['name' => "Mahendra", 'religion_id' => 1],
            ['name' => "Maheshwari", 'religion_id' => 1],
            ['name' => "Mahindra", 'religion_id' => 1],
            ['name' => "Mahishya", 'religion_id' => 1],
            ['name' => "Majabi", 'religion_id' => 1],
            ['name' => "Mala", 'religion_id' => 1],
            ['name' => "Malayalee Variar", 'religion_id' => 1],
            ['name' => "Mali", 'religion_id' => 1],
            ['name' => "Mallah", 'religion_id' => 1],
            ['name' => "Mangalorean", 'religion_id' => 1],
            ['name' => "Maniyani", 'religion_id' => 1],
            ['name' => "Mannadiar", 'religion_id' => 1],
            ['name' => "Mannan", 'religion_id' => 1],
            ['name' => "Mapila", 'religion_id' => 1],
            ['name' => "Marar", 'religion_id' => 1],
            ['name' => "Maratha", 'religion_id' => 1],
            ['name' => "Maratha - All", 'religion_id' => 1],
            ['name' => "Maratha - Gomantak", 'religion_id' => 1],
            ['name' => "Maruthuvar", 'religion_id' => 1],
            ['name' => "Marvar", 'religion_id' => 1],
            ['name' => "Marwari", 'religion_id' => 1],
            ['name' => "Matang", 'religion_id' => 1],
            ['name' => "Maurya", 'religion_id' => 1],
            ['name' => "Meda", 'religion_id' => 1],
            ['name' => "Medara", 'religion_id' => 1],
            ['name' => "Meena", 'religion_id' => 1],
            ['name' => "Meenavar", 'religion_id' => 1],
            ['name' => "Meghwal", 'religion_id' => 1],
            ['name' => "Mehra", 'religion_id' => 1],
            ['name' => "Menon", 'religion_id' => 1],
            ['name' => "Meru Darji", 'religion_id' => 1],
            ['name' => "Modak", 'religion_id' => 1],
            ['name' => "Mogaveera", 'religion_id' => 1],
            ['name' => "Monchi", 'religion_id' => 1],
            ['name' => "Mudaliar", 'religion_id' => 1],
            ['name' => "Mudaliar - All", 'religion_id' => 1],
            ['name' => "Mudaliar - Arcot", 'religion_id' => 1],
            ['name' => "Mudaliar - Saiva", 'religion_id' => 1],
            ['name' => "Mudaliar - Senguntha", 'religion_id' => 1],
            ['name' => "Mudiraj", 'religion_id' => 1],
            ['name' => "Munnuru Kapu", 'religion_id' => 1],
            ['name' => "Muthuraja", 'religion_id' => 1],
            ['name' => "Naagavamsam", 'religion_id' => 1],
            ['name' => "Nadar", 'religion_id' => 1],
            ['name' => "Nagaralu", 'religion_id' => 1],
            ['name' => "Nai", 'religion_id' => 1],
            ['name' => "Naicken", 'religion_id' => 1],
            ['name' => "Naicker", 'religion_id' => 1],
            ['name' => "Naidu", 'religion_id' => 1],
            ['name' => "Naik", 'religion_id' => 1],
            ['name' => "Nair", 'religion_id' => 1],
            ['name' => "Nair - All", 'religion_id' => 1],
            ['name' => "Nair - Vaniya", 'religion_id' => 1],
            ['name' => "Nair - Velethadathu", 'religion_id' => 1],
            ['name' => "Nair - Vilakkithala", 'religion_id' => 1],
            ['name' => "Namasudra", 'religion_id' => 1],
            ['name' => "Nambiar", 'religion_id' => 1],
            ['name' => "Nambisan", 'religion_id' => 1],
            ['name' => "Namdev", 'religion_id' => 1],
            ['name' => "Namosudra", 'religion_id' => 1],
            ['name' => "Napit", 'religion_id' => 1],
            ['name' => "Nayak", 'religion_id' => 1],
            ['name' => "Nayaka", 'religion_id' => 1],
            ['name' => "Neeli", 'religion_id' => 1],
            ['name' => "Nepali", 'religion_id' => 1],
            ['name' => "Nhavi", 'religion_id' => 1],
            ['name' => "OBC - Barber/Naayee", 'religion_id' => 1],
            ['name' => "Oswal", 'religion_id' => 1],
            ['name' => "Otari", 'religion_id' => 1],
            ['name' => "Other", 'religion_id' => 1],
            ['name' => "Padmasali", 'religion_id' => 1],
            ['name' => "Panchal", 'religion_id' => 1],
            ['name' => "Pandaram", 'religion_id' => 1],
            ['name' => "Panicker", 'religion_id' => 1],
            ['name' => "Paravan", 'religion_id' => 1],
            ['name' => "Parit", 'religion_id' => 1],
            ['name' => "Parkava Kulam", 'religion_id' => 1],
            ['name' => "Partraj", 'religion_id' => 1],
            ['name' => "Pasi", 'religion_id' => 1],
            ['name' => "Paswan", 'religion_id' => 1],
            ['name' => "Patel", 'religion_id' => 1],
            ['name' => "Patel - All", 'religion_id' => 1],
            ['name' => "Patel - Desai", 'religion_id' => 1],
            ['name' => "Patel - Dodia", 'religion_id' => 1],
            ['name' => "Patel - Kadva", 'religion_id' => 1],
            ['name' => "Patel - Leva", 'religion_id' => 1],
            ['name' => "Patnaick", 'religion_id' => 1],
            ['name' => "Patra", 'religion_id' => 1],
            ['name' => "Patwa", 'religion_id' => 1],
            ['name' => "Perika", 'religion_id' => 1],
            ['name' => "Pillai", 'religion_id' => 1],
            ['name' => "Pisharody", 'religion_id' => 1],
            ['name' => "Poduval", 'religion_id' => 1],
            ['name' => "Poosala", 'religion_id' => 1],
            ['name' => "Porwal", 'religion_id' => 1],
            ['name' => "Prajapati", 'religion_id' => 1],
            ['name' => "Pulaya", 'religion_id' => 1],
            ['name' => "Punjabi", 'religion_id' => 1],
            ['name' => "Raigar", 'religion_id' => 1],
            ['name' => "Rajaka", 'religion_id' => 1],
            ['name' => "Rajaka/Chakali/Dhobi", 'religion_id' => 1],
            ['name' => "Rajbhar", 'religion_id' => 1],
            ['name' => "Rajput", 'religion_id' => 1],
            ['name' => "Rajput - All", 'religion_id' => 1],
            ['name' => "Rajput - Garhwali", 'religion_id' => 1],
            ['name' => "Rajput - Kumaoni", 'religion_id' => 1],
            ['name' => "Rajput - Lodhi", 'religion_id' => 1],
            ['name' => "Ramdasia", 'religion_id' => 1],
            ['name' => "Ramgharia", 'religion_id' => 1],
            ['name' => "Rauniyar", 'religion_id' => 1],
            ['name' => "Ravidasia", 'religion_id' => 1],
            ['name' => "Rawat", 'religion_id' => 1],
            ['name' => "Reddiar", 'religion_id' => 1],
            ['name' => "Reddy", 'religion_id' => 1],
            ['name' => "Relli", 'religion_id' => 1],
            ['name' => "SSK", 'religion_id' => 1],
            ['name' => "Sadgop", 'religion_id' => 1],
            ['name' => "Sagara - Uppara", 'religion_id' => 1],
            ['name' => "Saha", 'religion_id' => 1],
            ['name' => "Sahu", 'religion_id' => 1],
            ['name' => "Saini", 'religion_id' => 1],
            ['name' => "Saiva Vellala", 'religion_id' => 1],
            ['name' => "Saliya", 'religion_id' => 1],
            ['name' => "Sambava", 'religion_id' => 1],
            ['name' => "Satnami", 'religion_id' => 1],
            ['name' => "Savji", 'religion_id' => 1],
            ['name' => "Scheduled Caste (SC)", 'religion_id' => 1],
            ['name' => "Scheduled Tribe (ST)", 'religion_id' => 1],
            ['name' => "Senai Thalaivar", 'religion_id' => 1],
            ['name' => "Sepahia", 'religion_id' => 1],
            ['name' => "Setti Balija", 'religion_id' => 1],
            ['name' => "Shah", 'religion_id' => 1],
            ['name' => "Shilpkar", 'religion_id' => 1],
            ['name' => "Shimpi", 'religion_id' => 1],
            ['name' => "Sindhi", 'religion_id' => 1],
            ['name' => "Sindhi - All", 'religion_id' => 1],
            ['name' => "Sindhi - Bhanusali", 'religion_id' => 1],
            ['name' => "Sindhi - Bhatia", 'religion_id' => 1],
            ['name' => "Sindhi - Chhapru", 'religion_id' => 1],
            ['name' => "Sindhi - Dadu", 'religion_id' => 1],
            ['name' => "Sindhi - Hyderabadi", 'religion_id' => 1],
            ['name' => "Sindhi - Larai", 'religion_id' => 1],
            ['name' => "Sindhi - Lohana", 'religion_id' => 1],
            ['name' => "Sindhi - Rohiri", 'religion_id' => 1],
            ['name' => "Sindhi - Sehwani", 'religion_id' => 1],
            ['name' => "Sindhi - Thatai", 'religion_id' => 1],
            ['name' => "Sindhi-Amil", 'religion_id' => 1],
            ['name' => "Sindhi-Baibhand", 'religion_id' => 1],
            ['name' => "Sindhi-Larkana", 'religion_id' => 1],
            ['name' => "Sindhi-Sahiti", 'religion_id' => 1],
            ['name' => "Sindhi-Sakkhar", 'religion_id' => 1],
            ['name' => "Sindhi-Shikarpuri", 'religion_id' => 1],
            ['name' => "Somvanshi", 'religion_id' => 1],
            ['name' => "Sonar", 'religion_id' => 1],
            ['name' => "Soni", 'religion_id' => 1],
            ['name' => "Sourashtra", 'religion_id' => 1],
            ['name' => "Sowrashtra", 'religion_id' => 1],
            ['name' => "Sozhiya Vellalar", 'religion_id' => 1],
            ['name' => "Sri Vaishnava", 'religion_id' => 1],
            ['name' => "Srisayana", 'religion_id' => 1],
            ['name' => "Subarna Banik", 'religion_id' => 1],
            ['name' => "Sugali (Naika)", 'religion_id' => 1],
            ['name' => "Sundhi", 'religion_id' => 1],
            ['name' => "Surya Balija", 'religion_id' => 1],
            ['name' => "Sutar", 'religion_id' => 1],
            ['name' => "Suthar", 'religion_id' => 1],
            ['name' => "Swakula Sali", 'religion_id' => 1],
            ['name' => "Swarnakar", 'religion_id' => 1],
            ['name' => "Tamboli", 'religion_id' => 1],
            ['name' => "Tamil Yadava", 'religion_id' => 1],
            ['name' => "Tanti", 'religion_id' => 1],
            ['name' => "Tantuway", 'religion_id' => 1],
            ['name' => "Telaga", 'religion_id' => 1],
            ['name' => "Teli", 'religion_id' => 1],
            ['name' => "Telugu", 'religion_id' => 1],
            ['name' => "Thachar", 'religion_id' => 1],
            ['name' => "Thakkar", 'religion_id' => 1],
            ['name' => "Thakur", 'religion_id' => 1],
            ['name' => "Thandan", 'religion_id' => 1],
            ['name' => "Thigala", 'religion_id' => 1],
            ['name' => "Thiyya", 'religion_id' => 1],
            ['name' => "Thuluva Vellala", 'religion_id' => 1],
            ['name' => "Tili", 'religion_id' => 1],
            ['name' => "Togata", 'religion_id' => 1],
            ['name' => "Turupu Kapu", 'religion_id' => 1],
            ['name' => "Udayar", 'religion_id' => 1],
            ['name' => "Urali Gounder", 'religion_id' => 1],
            ['name' => "Urs", 'religion_id' => 1],
            ['name' => "Vada Balija", 'religion_id' => 1],
            ['name' => "Vadagalai", 'religion_id' => 1],
            ['name' => "Vaddera", 'religion_id' => 1],
            ['name' => "Vaduka", 'religion_id' => 1],
            ['name' => "Vaish", 'religion_id' => 1],
            ['name' => "Vaish - All", 'religion_id' => 1],
            ['name' => "Vaish - Dhaneshawat", 'religion_id' => 1],
            ['name' => "Vaishnav", 'religion_id' => 1],
            ['name' => "Vaishnav - All", 'religion_id' => 1],
            ['name' => "Vaishnav - Bhatia", 'religion_id' => 1],
            ['name' => "Vaishnav - Vania", 'religion_id' => 1],
            ['name' => "Vaishya", 'religion_id' => 1],
            ['name' => "Vallala", 'religion_id' => 1],
            ['name' => "Valluvan", 'religion_id' => 1],
            ['name' => "Valmiki", 'religion_id' => 1],
            ['name' => "Vanika Vyshya", 'religion_id' => 1],
            ['name' => "Vaniya Chettiar", 'religion_id' => 1],
            ['name' => "Vanjara", 'religion_id' => 1],
            ['name' => "Vankar", 'religion_id' => 1],
            ['name' => "Vannan", 'religion_id' => 1],
            ['name' => "Vannar", 'religion_id' => 1],
            ['name' => "Vanniyakullak Kshatriya", 'religion_id' => 1],
            ['name' => "Vanniyar", 'religion_id' => 1],
            ['name' => "Variar", 'religion_id' => 1],
            ['name' => "Varshney", 'religion_id' => 1],
            ['name' => "Veera Saivam", 'religion_id' => 1],
            ['name' => "Veerashaiva", 'religion_id' => 1],
            ['name' => "Velaan", 'religion_id' => 1],
            ['name' => "Velama", 'religion_id' => 1],
            ['name' => "Velar", 'religion_id' => 1],
            ['name' => "Vellalar", 'religion_id' => 1],
            ['name' => "Veluthedathu - Nair", 'religion_id' => 1],
            ['name' => "Vettuva Gounder", 'religion_id' => 1],
            ['name' => "Vishwakarma", 'religion_id' => 1],
            ['name' => "Viswabrahmin", 'religion_id' => 1],
            ['name' => "Vokaliga", 'religion_id' => 1],
            ['name' => "Vokkaliga", 'religion_id' => 1],
            ['name' => "Vysya", 'religion_id' => 1],
            ['name' => "Waada Balija", 'religion_id' => 1],
            ['name' => "Yadav", 'religion_id' => 1],
            ['name' => "Yellapu", 'religion_id' => 1],

            // Muslim communities
            ['name' => "Ansari", 'religion_id' => 2],
            ['name' => "Arain", 'religion_id' => 2],
            ['name' => "Awan", 'religion_id' => 2],
            ['name' => "Bengali", 'religion_id' => 2],
            ['name' => "Dawoodi Bohra", 'religion_id' => 2],
            ['name' => "Dekkani", 'religion_id' => 2],
            ['name' => "Dudekula", 'religion_id' => 2],
            ['name' => "Jat", 'religion_id' => 2],
            ['name' => "Khoja", 'religion_id' => 2],
            ['name' => "Lebbai", 'religion_id' => 2],
            ['name' => "Mapila", 'religion_id' => 2],
            ['name' => "Maraicar", 'religion_id' => 2],
            ['name' => "Memon", 'religion_id' => 2],
            ['name' => "Mughal", 'religion_id' => 2],
            ['name' => "Pathan", 'religion_id' => 2],
            ['name' => "Qureshi", 'religion_id' => 2],
            ['name' => "Rajput", 'religion_id' => 2],
            ['name' => "Rowther", 'religion_id' => 2],
            ['name' => "Shafi", 'religion_id' => 2],
            ['name' => "Sheikh", 'religion_id' => 2],
            ['name' => "Shia - All", 'religion_id' => 2],
            ['name' => "Shia", 'religion_id' => 2],
            ['name' => "Shia Bohra", 'religion_id' => 2],
            ['name' => "Shia Imami Ismaili", 'religion_id' => 2],
            ['name' => "Shia Ithna ashariyyah", 'religion_id' => 2],
            ['name' => "Shia Zaidi", 'religion_id' => 2],
            ['name' => "Siddiqui", 'religion_id' => 2],
            ['name' => "Sunni - All", 'religion_id' => 2],
            ['name' => "Sunni", 'religion_id' => 2],
            ['name' => "Sunni Ehle-Hadith", 'religion_id' => 2],
            ['name' => "Sunni Hanafi", 'religion_id' => 2],
            ['name' => "Sunni Hunbali", 'religion_id' => 2],
            ['name' => "Sunni Maliki", 'religion_id' => 2],
            ['name' => "Sunni Shafi", 'religion_id' => 2],
            ['name' => "Syed", 'religion_id' => 2],
            // Christian communities

            ['name' => "Anglo Indian", 'religion_id' => 3],
            ['name' => "Basel Mission", 'religion_id' => 3],
            ['name' => "Born Again", 'religion_id' => 3],
            ['name' => "Bretheren", 'religion_id' => 3],
            ['name' => "Cannonite", 'religion_id' => 3],
            ['name' => "Catholic", 'religion_id' => 3],
            ['name' => "Catholic Malankara", 'religion_id' => 3],
            ['name' => "Chaldean Syrian", 'religion_id' => 3],
            ['name' => "Cheramar", 'religion_id' => 3],
            ['name' => "Christian Nadar", 'religion_id' => 3],
            ['name' => "Church of North India (CNI)", 'religion_id' => 3],
            ['name' => "Church of South India (CSI)", 'religion_id' => 3],
            ['name' => "CMS", 'religion_id' => 3],
            ['name' => "Convert", 'religion_id' => 3],
            ['name' => "Evangelical", 'religion_id' => 3],
            ['name' => "Indian Orthodox", 'religion_id' => 3],
            ['name' => "Intercaste", 'religion_id' => 3],
            ['name' => "IPC", 'religion_id' => 3],
            ['name' => "Jacobite", 'religion_id' => 3],
            ['name' => "Knanaya", 'religion_id' => 3],
            ['name' => "Knanya", 'religion_id' => 3],
            ['name' => "Latin Catholic", 'religion_id' => 3],
            ['name' => "Marthoma", 'religion_id' => 3],
            ['name' => "Methodist", 'religion_id' => 3],
            ['name' => "Mormon", 'religion_id' => 3],
            ['name' => "Orthodox", 'religion_id' => 3],
            ['name' => "Pentecost", 'religion_id' => 3],
            ['name' => "Presbyterian", 'religion_id' => 3],
            ['name' => "Protestant", 'religion_id' => 3],
            ['name' => "RCSC", 'religion_id' => 3],
            ['name' => "Roman Catholic", 'religion_id' => 3],
            ['name' => "Salvation Army", 'religion_id' => 3],
            ['name' => "Scheduled Caste (SC)", 'religion_id' => 3],
            ['name' => "Scheduled Tribe (ST)", 'religion_id' => 3],
            ['name' => "Seventh day Adventist", 'religion_id' => 3],
            ['name' => "Syrian", 'religion_id' => 3],
            ['name' => "Syrian Catholic", 'religion_id' => 3],
            ['name' => "Syrian Orthodox", 'religion_id' => 3],
            ['name' => "Syro Malabar", 'religion_id' => 3],
            ['name' => "Catholic Knanya", 'religion_id' => 3],
            ['name' => "Jacobite Knanya", 'religion_id' => 3],
            ['name' => "Knanaya Catholic", 'religion_id' => 3],
            ['name' => "Knanaya Jacobite", 'religion_id' => 3],
            ['name' => "Knanaya Pentecostal", 'religion_id' => 3],
            ['name' => "Malankara", 'religion_id' => 3],
            ['name' => "Malankara Catholic", 'religion_id' => 3],
            ['name' => "Manglorean", 'religion_id' => 3],
            ['name' => "Nadar", 'religion_id' => 3],
            //shikh communities
            ['name' => "Ahluwalia", 'religion_id' => 4],
            ['name' => "Arora", 'religion_id' => 4],
            ['name' => "Clean Shaven", 'religion_id' => 4],
            ['name' => "Gursikh", 'religion_id' => 4],
            ['name' => "Jat", 'religion_id' => 4],
            ['name' => "Kamboj", 'religion_id' => 4],
            ['name' => "Kesadhari", 'religion_id' => 4],
            ['name' => "Khatri", 'religion_id' => 4],
            ['name' => "Kshatriya", 'religion_id' => 4],
            ['name' => "Labana", 'religion_id' => 4],
            ['name' => "Mazhbi/Majabi", 'religion_id' => 4],
            ['name' => "Rajput", 'religion_id' => 4],
            ['name' => "Ramdasia", 'religion_id' => 4],
            ['name' => "Ramgharia", 'religion_id' => 4],
            ['name' => "Ravidasia", 'religion_id' => 4],
            ['name' => "Saini", 'religion_id' => 4],

            //Jain
            ['name' => "Digambar", 'religion_id' => 6],
            ['name' => "Porwal", 'religion_id' => 6],
            ['name' => "Shwetamber", 'religion_id' => 6],
            ['name' => "Vania", 'religion_id' => 6],
            ['name' => "Oswal", 'religion_id' => 6],
            ['name' => "Agrawal Jain", 'religion_id' => 6],
            ['name' => "Khandelwal Jain", 'religion_id' => 6],
            
            
            // Jewish - Sephardi, Ashkenazi, Jewish - Others
            ['name' => "Sephardi", 'religion_id' => 8],
            ['name' => "Ashkenazi", 'religion_id' => 8],
            
            // parsi - Irani, Zoroastrian
            ['name' => "Irani", 'religion_id' => 5],
            ['name' => "Zoroastrian", 'religion_id' => 5],

        ];





        foreach ($communities as $c) {
            DB::table('communities')->insert([
                'name' => $c['name'],
                'religion_id' => $c['religion_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
