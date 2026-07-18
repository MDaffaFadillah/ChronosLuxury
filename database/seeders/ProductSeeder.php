<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil kategori untuk referensi ID
        $diverId = Category::where('slug', 'diver')->first()->id;
        $chronoId = Category::where('slug', 'chronograph')->first()->id;
        $dressId = Category::where('slug', 'dress')->first()->id;
        $classicId = Category::where('slug', 'classic')->first()->id;

        $products = [
            // DIVER
            [
                'category_id' => $diverId,
                'name' => 'Submariner Date 41',
                'slug' => 'submariner-date-41',
                'description' => 'The Oyster Perpetual Submariner Date in Oystersteel and yellow gold with a Cerachrom bezel insert in blue ceramic and a royal blue dial with large luminescent hour markers.',
                'price' => 281516000,
                'stock' => 5,
                'image' => 'assets/images/diver-submariner.png',
                'featured' => true,
                'reference_number' => '126613LB',
                'movement' => 'Calibre 3235, Manufacture Rolex',
                'case_material' => 'Yellow Rolesor - combination of Oystersteel and yellow gold',
                'dial_color' => 'Royal Blue',
                'bracelet' => 'Oyster, flat three-piece links',
                'power_reserve' => 'Approximately 70 hours',
                'water_resistance' => 'Waterproof to 300 metres / 1,000 feet',
                'case_diameter' => '41 mm',
                'condition' => 'Unworn (2026)'
            ],
            [
                'category_id' => $diverId,
                'name' => 'Submariner "Kermit" Green',
                'slug' => 'submariner-kermit-green',
                'description' => 'The Oyster Perpetual Submariner Date in Oystersteel with a green Cerachrom bezel insert and a black dial. An icon of diving heritage.',
                'price' => 295000000,
                'stock' => 3,
                'image' => 'assets/images/diver-submariner.png',
                'featured' => false,
                'reference_number' => '126610LV',
                'movement' => 'Calibre 3235, Manufacture Rolex',
                'case_material' => 'Oystersteel',
                'dial_color' => 'Black',
                'bracelet' => 'Oyster, flat three-piece links',
                'power_reserve' => 'Approximately 70 hours',
                'water_resistance' => 'Waterproof to 300 metres / 1,000 feet',
                'case_diameter' => '41 mm',
                'condition' => 'Very Good (2024)'
            ],
            [
                'category_id' => $diverId,
                'name' => 'Sea-Dweller Deepsea Black',
                'slug' => 'sea-dweller-deepsea-black',
                'description' => 'Citizen of the deep. Water resistant up to 3,900 meters. Features a black dial and a thick domed sapphire crystal.',
                'price' => 245000000,
                'stock' => 2,
                'image' => 'assets/images/diver-submariner.png',
                'featured' => false,
                'reference_number' => '136660',
                'movement' => 'Calibre 3235, Manufacture Rolex',
                'case_material' => 'Oystersteel with RLX Titanium case back',
                'dial_color' => 'Black',
                'bracelet' => 'Oyster, flat three-piece links',
                'power_reserve' => 'Approximately 70 hours',
                'water_resistance' => 'Waterproof to 3,900 metres / 12,800 feet',
                'case_diameter' => '44 mm',
                'condition' => 'Pristine (2025)'
            ],

            // CHRONOGRAPH
            [
                'category_id' => $chronoId,
                'name' => 'Cosmograph Daytona Platinum',
                'slug' => 'cosmograph-daytona-platinum',
                'description' => 'This model features an ice-blue dial with chestnut brown Cerachrom bezel and chronograph counters, designed to be the ultimate elapsed-time tracking tool for endurance racing drivers.',
                'price' => 1180855000,
                'stock' => 1,
                'image' => 'assets/images/chrono-daytona.png',
                'featured' => true,
                'reference_number' => '126506',
                'movement' => 'Calibre 4131, Manufacture Rolex',
                'case_material' => 'Platinum (950 Platinum)',
                'dial_color' => 'Ice Blue',
                'bracelet' => 'Oyster, flat three-piece links',
                'power_reserve' => 'Approximately 72 hours',
                'water_resistance' => 'Waterproof to 100 metres / 330 feet',
                'case_diameter' => '40 mm',
                'condition' => 'Unworn (2026), Box & Papers'
            ],
            [
                'category_id' => $chronoId,
                'name' => 'Yacht-Master II Daytona Gold',
                'slug' => 'yacht-master-ii-daytona-gold',
                'description' => 'A unique regatta chronograph dedicated to yachting enthusiasts. Features an Everose Rolesor bracelet and white dial with sub-dials.',
                'price' => 584218000,
                'stock' => 2,
                'image' => 'assets/images/yatch-daytona.png',
                'featured' => true,
                'reference_number' => '116681',
                'movement' => 'Calibre 4161, Manufacture Rolex',
                'case_material' => 'Everose Rolesor - combination of Oystersteel and Everose gold',
                'dial_color' => 'White',
                'bracelet' => 'Oyster, flat three-piece links',
                'power_reserve' => 'Approximately 72 hours',
                'water_resistance' => 'Waterproof to 100 metres / 330 feet',
                'case_diameter' => '44 mm',
                'condition' => 'Unworn (2025)'
            ],
            [
                'category_id' => $chronoId,
                'name' => 'Daytona Oystersteel Black Dial',
                'slug' => 'daytona-oystersteel-black-dial',
                'description' => 'The legendary chronograph crafted in Oystersteel with a black Cerachrom bezel and matching black dial. Highly sought-after worldwide.',
                'price' => 450000000,
                'stock' => 2,
                'image' => 'assets/images/chrono-daytona.png',
                'featured' => false,
                'reference_number' => '126500LN',
                'movement' => 'Calibre 4131, Manufacture Rolex',
                'case_material' => 'Oystersteel',
                'dial_color' => 'Black',
                'bracelet' => 'Oyster, flat three-piece links',
                'power_reserve' => 'Approximately 72 hours',
                'water_resistance' => 'Waterproof to 100 metres / 330 feet',
                'case_diameter' => '40 mm',
                'condition' => 'Lightly Used (2024)'
            ],

            // DRESS
            [
                'category_id' => $dressId,
                'name' => 'Lady-Datejust 28 Yellow Gold',
                'slug' => 'lady-datejust-28-yellow-gold',
                'description' => 'The classic feminine timepiece. Features a silver dial set with diamonds, a fluted bezel, and a prestige Jubilee bracelet in yellow gold.',
                'price' => 258843000,
                'stock' => 4,
                'image' => 'assets/images/dress-datajust.png',
                'featured' => true,
                'reference_number' => '279173',
                'movement' => 'Calibre 2236, Manufacture Rolex',
                'case_material' => 'Yellow Rolesor - combination of Oystersteel and yellow gold',
                'dial_color' => 'Silver Dial with Diamonds',
                'bracelet' => 'Jubilee, five-piece links',
                'power_reserve' => 'Approximately 55 hours',
                'water_resistance' => 'Waterproof to 100 metres / 330 feet',
                'case_diameter' => '28 mm',
                'condition' => 'Unworn (2026)'
            ],
            [
                'category_id' => $dressId,
                'name' => 'Sky-Dweller Everose Gold',
                'slug' => 'sky-dweller-everose-gold',
                'description' => 'Designed for global travelers. Features a dual time zone display with annual calendar, crafted in full 18 ct Everose gold with a chocolate brown dial.',
                'price' => 1114727000,
                'stock' => 1,
                'image' => 'assets/images/yatch-daytona.png', // Fallback to premium dress looking watch
                'featured' => true,
                'reference_number' => '336935',
                'movement' => 'Calibre 9002, Manufacture Rolex',
                'case_material' => '18 ct Everose gold',
                'dial_color' => 'Intense White / Chocolate',
                'bracelet' => 'Oyster, flat three-piece links',
                'power_reserve' => 'Approximately 72 hours',
                'water_resistance' => 'Waterproof to 100 metres / 330 feet',
                'case_diameter' => '42 mm',
                'condition' => 'Pristine (2025)'
            ],
            [
                'category_id' => $dressId,
                'name' => 'Datejust 36 Mint Green Dial',
                'slug' => 'datejust-36-mint-green-dial',
                'description' => 'A symbol of classic style. Mint green dial with fluted bezel, set on a Jubilee steel bracelet. Perfectly proportioned elegant dress watch.',
                'price' => 198000000,
                'stock' => 6,
                'image' => 'assets/images/dress-datajust.png',
                'featured' => false,
                'reference_number' => '126234',
                'movement' => 'Calibre 3235, Manufacture Rolex',
                'case_material' => 'Oystersteel and white gold',
                'dial_color' => 'Mint Green',
                'bracelet' => 'Jubilee, five-piece links',
                'power_reserve' => 'Approximately 70 hours',
                'water_resistance' => 'Waterproof to 100 metres / 330 feet',
                'case_diameter' => '36 mm',
                'condition' => 'Unworn (2026)'
            ],

            // CLASSIC
            [
                'category_id' => $classicId,
                'name' => 'Oyster Perpetual 41 Green Dial',
                'slug' => 'oyster-perpetual-41-green-dial',
                'description' => 'With chronometric precision and robust design, this classic perpetual timepiece stands out with its bright lacquer green dial, clean Oystersteel case, and iconic domed bezel.',
                'price' => 200273000,
                'stock' => 8,
                'image' => 'assets/images/classic-oyster.png',
                'featured' => true,
                'reference_number' => '124300',
                'movement' => 'Calibre 3230, Manufacture Rolex',
                'case_material' => 'Oystersteel',
                'dial_color' => 'Green',
                'bracelet' => 'Oyster, flat three-piece links',
                'power_reserve' => 'Approximately 70 hours',
                'water_resistance' => 'Waterproof to 100 metres / 330 feet',
                'case_diameter' => '41 mm',
                'condition' => 'Unworn (2025)'
            ],
            [
                'category_id' => $classicId,
                'name' => 'Oyster Perpetual 36 Tiffany Blue',
                'slug' => 'oyster-perpetual-36-tiffany-blue',
                'description' => 'Highly coveted turquoise "Tiffany" blue dial lacquer. Elegant Oystersteel casing on Oyster bracelet. A timeless classic with a splash of color.',
                'price' => 258000000,
                'stock' => 3,
                'image' => 'assets/images/classic-oyster.png',
                'featured' => false,
                'reference_number' => '126000',
                'movement' => 'Calibre 3230, Manufacture Rolex',
                'case_material' => 'Oystersteel',
                'dial_color' => 'Turquoise Blue (Tiffany)',
                'bracelet' => 'Oyster, flat three-piece links',
                'power_reserve' => 'Approximately 70 hours',
                'water_resistance' => 'Waterproof to 100 metres / 330 feet',
                'case_diameter' => '36 mm',
                'condition' => 'Unworn (2024)'
            ],
            [
                'category_id' => $classicId,
                'name' => 'Explorer I Chronometer',
                'slug' => 'explorer-i-chronometer',
                'description' => 'Conquer new heights. Features the classic 3-6-9 black dial with outstanding legibility and rugged beauty.',
                'price' => 170000000,
                'stock' => 7,
                'image' => 'assets/images/classic-oyster.png',
                'featured' => false,
                'reference_number' => '124270',
                'movement' => 'Calibre 3230, Manufacture Rolex',
                'case_material' => 'Oystersteel',
                'dial_color' => 'Black',
                'bracelet' => 'Oyster, flat three-piece links',
                'power_reserve' => 'Approximately 70 hours',
                'water_resistance' => 'Waterproof to 100 metres / 330 feet',
                'case_diameter' => '36 mm',
                'condition' => 'Excellent (2023)'
            ]
        ];

        foreach ($products as $prod) {
            Product::updateOrCreate(['slug' => $prod['slug']], $prod);
        }
    }
}
