<?php

namespace Modules\Entertainment\database\seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Modules\Entertainment\Models\Review;
use Modules\MenuBuilder\Models\MenuBuilder;


class ReviewDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();


        $avatarPath = config('app.avatar_base_path');

        $reviews = [
            [
                'entertainment_id' => 8,
                'user_id' => 12,
                'rating' => 5,
                'review' => 'A gripping storyline with unexpected twists. Keeps you hooked till the very end. 🤯🔥',
            ],
            [
                'entertainment_id' => 5,
                'user_id' => 13,
                'rating' => 4,
                'review' => 'Amazing atmosphere and spooky vibes. Perfect for horror fans! 👁️🌑',
            ],
            [
                'entertainment_id' => 14,
                'user_id' => 8,
                'rating' => 4,
                'review' => 'Keeps you guessing with every turn. The Monkey King\'s journey is riveting and intense. 🤯👀',
            ],
            [
                'entertainment_id' => 8,
                'user_id' => 11,
                'rating' => 5,
                'review' => 'Non-stop action from start to finish! The fight scenes were incredible. 🎬💥',
            ],
            [
                'entertainment_id' => 2,
                'user_id' => 10,
                'rating' => 4,
                'review' => 'Absolutely loved the showdown scenes! The tension is palpable throughout. 🥳🎬',
            ],
            [
                'entertainment_id' => 13,
                'user_id' => 9,
                'rating' => 4,
                'review' => 'The cinematography and special effects are top-notch. A visual treat for action enthusiasts. 🌟🎥',
            ],
            [
                'entertainment_id' => 6,
                'user_id' => 14,
                'rating' => 5,
                'review' => 'Absolutely gripping from the first episode! The suspense is incredible. 🕵️‍♂️🔍',
            ],
            [
                'entertainment_id' => 17,
                'user_id' => 7,
                'rating' => 4,
                'review' => 'Hilarious from start to finish! Couldn\'t stop laughing! 😂👏',
            ],
            [
                'entertainment_id' => 6,
                'user_id' => 6,
                'rating' => 3,
                'review' => 'Brilliantly executed with superb acting. A must-watch for thriller fans. 🎭🌟',
            ],
            [
                'entertainment_id' => 7,
                'user_id' =>3,
                'rating' => 4,
                'review' => 'Fantastic choreography and intense combat sequences. Top-notch action film! 💪🎥',
            ],
            [
                'entertainment_id' => 4,
                'user_id' => 5,
                'rating' => 4,
                'review' => 'Each episode leaves you wanting more. The storyline is so gripping! 🎉🕶️',
            ],
            [
                'entertainment_id' => 1,
                'user_id' => 4,
                'rating' => 5,
                'review' => 'Perfectly blends psychological horror with supernatural elements, keeping you on the edge of your seat and craving for more after each episode. 🔮😱',
            ],
            [
                'entertainment_id' => 9,
                'user_id' => 9,
                'rating' => 5,
                'review' => 'A thrilling ride that keeps you hooked with its intense plot twists and stunning visuals. 🎬🌟',
            ],
            [
                'entertainment_id' => 10,
                'user_id' => 13,
                'rating' => 5,
                'review' => 'Loved the creativity and imagination in every scene. It\'s a delightful watch! 🌈✨',
            ],
            [
                'entertainment_id' => 1,
                'user_id' => 3,
                'rating' => 4,
                'review' => 'A chilling series that grips you from the first scene to the last, leaving you haunted by its eerie atmosphere and suspenseful plot twists. 👻🌑',
            ],
            [
                'entertainment_id' => 6,
                'user_id' => 5,
                'rating' => 4,
                'review' => 'The suspense is unbearable! Can’t wait for the next episode. 😬🚀',
            ],
            [
                'entertainment_id' => 3,
                'user_id' => 8,
                'rating' => 5,
                'review' => 'My favorite show this season! The Guardian\'s Challenge episode was thrilling! 🛡️🚀',
            ],
            [
                'entertainment_id' => 10,
                'user_id' => 3,
                'rating' => 4,
                'review' => 'A magical adventure with charming characters and beautiful animation! 🌼🌟',
            ],
            [
                'entertainment_id' => 8,
                'user_id' => 4,
                'rating' => 5,
                'review' => 'Amazing cinematography and special effects! Truly a visual treat. 🎥✨',
            ],
            [
                'entertainment_id' => 11,
                'user_id' => 10,
                'rating' => 4,
                'review' => 'Secrets of Zambezia delivers a powerful message with humor and adventure. 🌍😄',
            ],
            [
                'entertainment_id' => 16,
                'user_id' => 5,
                'rating' => 4,
                'review' => 'Couldn\'t stop laughing! The antics of Tim and Tom are pure genius. 🤣🎉',
            ],
            [
                'entertainment_id' => 7,
                'user_id' => 7,
                'rating' => 5,
                'review' => 'A thrilling ride with non-stop adrenaline! Couldn\'t take my eyes off the screen. 🚁🔥',
            ],
            [
                'entertainment_id' => 5,
                'user_id' => 4,
                'rating' => 5,
                'review' => 'The suspense and horror elements are top-notch. Can\'t wait for more! 👻🔪',
            ],
            [
                'entertainment_id' => 15,
                'user_id' => 8,
                'rating' => 5,
                'review' => 'Deep Sea Mysteries keeps you at the edge of your seat. Unveiling secrets of the deep has never been more thrilling! 🚢💀',
            ],
            [
                'entertainment_id' => 9,
                'user_id' => 7,
                'rating' => 5,
                'review' => 'Loved the character development and the emotional depth. It\'s more than just action- it\'s a redemption story! 👍🎥',
            ],
            [
                'entertainment_id' => 5,
                'user_id' => 8,
                'rating' => 5,
                'review' => 'Each episode gets better and scarier. Highly recommend! 🕸️🕷️',
            ],
            [
                'entertainment_id' => 9,
                'user_id' => 14,
                'rating' => 3,
                'review' => 'The Gunfighter\'s Redemption is a true masterpiece of action cinema. It leaves you wanting more with its gripping storyline and epic showdowns. 🏆🌌',
            ],
            [
                'entertainment_id' => 10,
                'user_id' => 4,
                'rating' => 3,
                'review' => 'Daizy\'s Enchanted Journey brings a smile to your face with its enchanting story. 🌸😄',
            ],
            [
                'entertainment_id' => 6,
                'user_id' => 3,
                'rating' => 4,
                'review' => 'Twists and turns at every corner! Keeps you guessing until the end. 🤯🔎',
            ],
            [
                'entertainment_id' => 2,
                'user_id' => 9,
                'rating' => 4,
                'review' => 'An intense start with plenty of action and a gripping storyline. Can\'t wait for more! 🤠🔥',
            ],
            [
                'entertainment_id' => 5,
                'user_id' => 3,
                'rating' => 3,
                'review' => 'A chilling start that kept me hooked from the first episode. So creepy! 😱🖤',
            ],
            [
                'entertainment_id' => 9,
                'user_id' => 10,
                'rating' => 5,
                'review' => 'The Gunfighter\'s quest for redemption is both heart-wrenching and exhilarating. Captivating from the first shot to the last. 💔🔫',
            ],
            [
                'entertainment_id' => 1,
                'user_id' => 5,
                'rating' => 4,
                'review' => 'An immersive journey into darkness where every shadow hides a secret, keeping you guessing and terrified until the very end. 🕯️😨',
            ],
            [
                'entertainment_id' => 22,
                'user_id' => 14,
                'rating' => 5,
                'review' => 'Impressive cinematography and a storyline that keeps you hooked till the end. 🎥👌',
            ],
            [
                'entertainment_id' => 14,
                'user_id' => 5,
                'rating' => 5,
                'review' => 'Gripping storyline with unexpected twists and heart-pounding action scenes! 🐒👑',
            ],
            [
                'entertainment_id' => 13,
                'user_id' => 3,
                'rating' => 4,
                'review' => 'Loved the protagonist\'s charisma and the intense plot twists. Keeps you guessing! 🔥🕵️‍♂️',
            ],
            [
                'entertainment_id' => 6,
                'user_id' => 4,
                'rating' => 5,
                'review' => 'The plot is so intricate and well-crafted. A real edge-of-your-seat thriller. 😲🔥',
            ],
            [
                'entertainment_id' => 2,
                'user_id' => 11,
                'rating' => 4,
                'review' => 'The characters are well-developed and the plot keeps you on the edge of your seat. 👍🕵️‍♂️',
            ],
            [
                'entertainment_id' => 3,
                'user_id' => 10,
                'rating' => 4,
                'review' => 'Raziel\'s journey is inspiring and beautifully animated. Can\'t wait for more! 🎉🦄',
            ],
            [
                'entertainment_id' => 7,
                'user_id' => 9,
                'rating' => 3,
                'review' => 'Heart-pounding action with a hint of suspense. Action movie buffs will enjoy every moment. 🎞️👏',
            ],
            [
                'entertainment_id' => 4,
                'user_id' => 12,
                'rating' => 4,
                'review' => 'The suspense in every episode keeps me hooked! Can\'t get enough of it. 🔍🎬',
            ],
            [
                'entertainment_id' => 10,
                'user_id' => 5,
                'rating' => 5,
                'review' => 'Perfect for family movie night - captivating and full of wonder! 🍿👪',
            ],
            [
                'entertainment_id' => 5,
                'user_id' => 7,
                'rating' => 5,
                'review' => 'The storyline is gripping and the scares are genuine. Loving it! 🎃💀',
            ],
            [
                'entertainment_id' => 12,
                'user_id' => 8,
                'rating' => 4,
                'review' => 'A visually stunning adventure that captivates from start to finish! 🎬🌟',
            ],
            [
                'entertainment_id' => 22,
                'user_id' => 11,
                'rating' => 5,
                'review' => 'Educational yet entertaining, perfect for history buffs and casual viewers alike. 📚📺',
            ],
            [
                'entertainment_id' => 5,
                'user_id' => 6,
                'rating' => 4,
                'review' => 'Edge-of-your-seat horror with a captivating plot. So intense! 🥶🏚️',
            ],
            [
                'entertainment_id' => 8,
                'user_id' => 3,
                'rating' => 5,
                'review' => 'The characters were so well-developed, and the plot was intense. Loved every moment! 👍🌟',
            ],
            [
                'entertainment_id' => 6,
                'user_id' => 8,
                'rating' => 5,
                'review' => 'The characters are compelling, and the mystery deepens with each episode. 👏🕵️‍♀️',
            ],
            [
                'entertainment_id' => 11,
                'user_id' => 6,
                'rating' => 5,
                'review' => 'Loved the soundtrack! It perfectly complements the magical atmosphere of Zambezia. 🎵🎶',
            ],
            [
                'entertainment_id' => 15,
                'user_id' => 4,
                'rating' => 5,
                'review' => 'The ocean depths come alive with mystery and danger. Riveting from start to finish. 🌊🦑',
            ],
            [
                'entertainment_id' => 6,
                'user_id' => 9,
                'rating' => 3,
                'review' => 'Each episode unveils more secrets and keeps you hooked. Fantastic storytelling! 📚🎬',
            ],
            [
                'entertainment_id' => 7,
                'user_id' => 6,
                'rating' => 4,
                'review' => 'Action-packed from start to finish! The stunts were mind-blowing. 🎬💥',
            ],
            [
                'entertainment_id' => 8,
                'user_id' => 13,
                'rating' => 5,
                'review' => 'The pacing was perfect, never a dull moment. Can\'t wait for a sequel! 🚀🎉',
            ],
            [
                'entertainment_id' => 16,
                'user_id' => 14,
                'rating' => 3,
                'review' => 'Tim and Tom\'s chemistry is unbeatable. I wish there were more movies like this! 🌟👬',
            ],
            [
                'entertainment_id' => 9,
                'user_id' => 6,
                'rating' => 5,
                'review' => 'Action-packed and emotionally charged—this movie delivers on all fronts. A must-watch for action enthusiasts! 💥🎞️',
            ],
            [
                'entertainment_id' => 18,
                'user_id' => 11,
                'rating' => 4,
                'review' => 'I couldn\'t get enough of the comedic timing in this film. Pure comedy gold! ⏱️😄',
            ],
            [
                'entertainment_id' => 8,
                'user_id' => 14,
                'rating' => 5,
                'review' => 'A thrilling ride with heart-pounding moments. Definitely recommend it to action fans! 🎢👏',
            ],
            [
                'entertainment_id' => 11,
                'user_id' => 7,
                'rating' => 5,
                'review' => 'The storyline is engaging, and the characters are lovable. A must-watch animation! 🐦💖',
            ],
            [
                'entertainment_id' => 5,
                'user_id' => 9,
                'rating' => 5,
                'review' => 'The acting and special effects are fantastic. Truly terrifying! 🌲🧟‍♀️',
            ],
            [
                'entertainment_id' => 12,
                'user_id' => 14,
                'rating' => 5,
                'review' => 'Clever humor and heartfelt moments make this a timeless classic. Highly recommend! 😄👏',
            ],
            [
                'entertainment_id' => 22,
                'user_id' => 4,
                'rating' => 5,
                'review' => 'The costumes and set designs transport you back in time. A visual feast! 🎨✨',
            ],
            [
                'entertainment_id' => 9,
                'user_id' => 5,
                'rating' => 4,
                'review' => 'Gripping action from start to finish! The Gunfighter\'s journey is packed with adrenaline-pumping scenes. 🤠🔥',
            ],
            [
                'entertainment_id' => 26,
                'user_id' => 14,
                'rating' => 4,
                'review' => 'The scenery and music complement the story beautifully. It\'s a visual and emotional treat. 🎵🎥',
            ],
            [
                'entertainment_id' => 15,
                'user_id' => 11,
                'rating' => 4,
                'review' => 'Intriguing characters and a plot that sinks its hooks deep. Thrills and suspense galore! 👀🎥',
            ],
            [
                'entertainment_id' => 17,
                'user_id' => 6,
                'rating' => 5,
                'review' => 'Clever humor and witty dialogue make this a must-watch comedy! 🎭👍',
            ],
            [
                'entertainment_id' => 13,
                'user_id' => 14,
                'rating' => 4,
                'review' => 'Gripping storyline with unexpected turns. I couldn\'t look away for a second! 🤯🔫',
            ],
            [
                'entertainment_id' => 19,
                'user_id' => 11,
                'rating' => 5,
                'review' => 'Creepy atmosphere and unexpected twists make it a standout horror film. 🌑🕯️',
            ],
            [
                'entertainment_id' => 7,
                'user_id' => 8,
                'rating' => 3,
                'review' => 'Explosive scenes and gripping storyline. Kept me at the edge of my seat throughout. 🌟🔫',
            ],
            [
                'entertainment_id' => 16,
                'user_id' => 10,
                'rating' => 4,
                'review' => 'A delightful comedy that had me giggling throughout. Tim and Tom are my new favorites! 🎈😁',
            ],
            [
                'entertainment_id' => 7,
                'user_id' => 10,
                'rating' => 5,
                'review' => 'Loved the plot twists and the lead actor\'s performance. Definitely worth watching! 👍🎬',
            ],
            [
                'entertainment_id' => 11,
                'user_id' => 3,
                'rating' => 4,
                'review' => 'Captivating animation and a heartwarming storyline that keeps you engaged till the end. 🌟🎬',
            ],
            [
                'entertainment_id' => 16,
                'user_id' => 13,
                'rating' => 5,
                'review' => 'A feel-good movie with endless laughs. Perfect for a movie night with friends! 🍿😆',
            ],
            [
                'entertainment_id' => 11,
                'user_id' => 11,
                'rating' => 5,
                'review' => 'Beautifully crafted characters and stunning visuals. A delight for all ages! 🦅🎨',
            ],
            [
                'entertainment_id' => 23,
                'user_id' => 8,
                'rating' => 5,
                'review' => 'A feel-good film that leaves you motivated and optimistic. 🎥🌻',
            ],
            [
                'entertainment_id' => 12,
                'user_id' => 12,
                'rating' => 5,
                'review' => 'The animation is top-notch, and the plot is both engaging and thought-provoking. 🎥🤔',
            ],
            [
                'entertainment_id' => 13,
                'user_id' => 7,
                'rating' => 3,
                'review' => 'Perfect blend of action and suspense. It kept me at the edge of my seat throughout. 👏🎭',
            ],
            [
                'entertainment_id' => 18,
                'user_id' => 14,
                'rating' => 4,
                'review' => 'Frank and Fearless bring laughter and charm to the screen. Thoroughly entertaining! 😂🎉',
            ],
            [
                'entertainment_id' => 13,
                'user_id' => 4,
                'rating' => 5,
                'review' => 'Action-packed from start to finish! The stunts and fight scenes are mind-blowing. 🎬💥',
            ],
            [
                'entertainment_id' => 17,
                'user_id' => 5,
                'rating' => 3,
                'review' => 'The cast nailed it! Each scene had me in stitches. 🤣🎬',
            ],
            [
                'entertainment_id' => 15,
                'user_id' => 12,
                'rating' => 5,
                'review' => 'Captivating storyline with chilling moments that leave you breathless. A must-watch for thriller enthusiasts! 😱🎬',
            ],
            [
                'entertainment_id' => 13,
                'user_id' => 13,
                'rating' => 4,
                'review' => 'Heart-pounding adrenaline rush! The Daring Player sets a new standard for action movies. 🚀👊',
            ],
            [
                'entertainment_id' => 14,
                'user_id' => 11,
                'rating' => 5,
                'review' => 'Impressive cinematography and a plot that keeps you on the edge of your seat. Bravo! 🌟👏',
            ],
            [
                'entertainment_id' => 19,
                'user_id' => 4,
                'rating' => 5,
                'review' => 'A terrifying rollercoaster of fear and suspense. 🎢😨',
            ],
            [
                'entertainment_id' => 21,
                'user_id' => 10,
                'rating' => 4,
                'review' => 'Engrossing narratives and stunning visuals make history come alive! 🎥✨',
            ],
            [
                'entertainment_id' => 25,
                'user_id' => 13,
                'rating' => 5,
                'review' => 'I couldn\'t stop smiling throughout! A perfect feel-good movie for any day. 😊🎥',
            ],
            [
                'entertainment_id' => 14,
                'user_id' => 10,
                'rating' => 4,
                'review' => 'The suspense builds up perfectly. I couldn\'t take my eyes off the screen! 🎥🔍',
            ],
            [
                'entertainment_id' => 1,
                'user_id' => 6,
                'rating' => 4,
                'review' => 'Masterfully crafted with spine-tingling moments that linger long after you\'ve finished watching. A must-watch for horror aficionados! 🎬👻',
            ],
            [
                'entertainment_id' => 15,
                'user_id' => 3,
                'rating' => 5,
                'review' => 'Gripping plot twists and eerie underwater suspense! Keeps you guessing till the end. 🌊🔍',
            ],
            [
                'entertainment_id' => 26,
                'user_id' => 5,
                'rating' => 4,
                'review' => 'A perfect movie for a cozy evening. It\'s romantic, emotional, and uplifting. 🍿🎬',
            ],
            [
                'entertainment_id' => 21,
                'user_id' => 13,
                'rating' => 5,
                'review' => 'Detailed and enlightening! It\'s like stepping back in time. 🕰️📜',
            ],
            [
                'entertainment_id' => 19,
                'user_id' => 7,
                'rating' => 3,
                'review' => 'Hauntingly good! The suspense builds up perfectly. 🕰️🔦',
            ],
            [
                'entertainment_id' => 16,
                'user_id' => 9,
                'rating' => 4,
                'review' => 'Hilarious from start to finish! Tim and Tom are comedy gold. 😂👌',
            ],
            [
                'entertainment_id' => 24,
                'user_id' => 13,
                'rating' => 5,
                'review' => 'An emotional rollercoaster with a powerful message of perseverance. 🎢💫',
            ],
            [
                'entertainment_id' => 23,
                'user_id' => 5,
                'rating' => 4,
                'review' => 'Rise Above is a testament to the human spirit\'s ability to overcome challenges. 🌠🙌',
            ],
            [
                'entertainment_id' => 26,
                'user_id' => 12,
                'rating' => 5,
                'review' => 'This movie reminds us that love conquers all. It\'s a must-watch for romantics! 🌹💫',
            ],
            [
                'entertainment_id' => 16,
                'user_id' => 6,
                'rating' => 5,
                'review' => 'Quirky and entertaining, this movie brightened my day. Highly recommend! 🌈❤️',
            ],
            [
                'entertainment_id' => 17,
                'user_id' => 3,
                'rating' => 5,
                'review' => 'Perfect pick-me-up comedy for any day of the week. 😄🎥',
            ],
            [
                'entertainment_id' => 15,
                'user_id' => 7,
                'rating' => 5,
                'review' => 'Atmospheric and hauntingly beautiful. Dive into this thriller for an unforgettable ride. 🌊🎞️',
            ],
            [
                'entertainment_id' => 17,
                'user_id' => 10,
                'rating' => 3,
                'review' => 'A feel-good comedy that delivers non-stop laughs. Highly recommend! 🌟🎉',
            ],
            [
                'entertainment_id' => 24,
                'user_id' => 8,
                'rating' => 5,
                'review' => 'Inspirational from start to finish. It reminds us to never give up on our dreams. 🌟🎬',
            ],
            [
                'entertainment_id' => 18,
                'user_id' => 9,
                'rating' => 5,
                'review' => 'The chemistry between the characters is spot-on. Enjoyable and witty! 👏😆',
            ],
            [
                'entertainment_id' => 21,
                'user_id' => 6,
                'rating' => 3,
                'review' => 'Each episode is a treasure trove of knowledge. Highly recommend for all ages! 🎓🌟',
            ],
            [
                'entertainment_id' => 23,
                'user_id' => 11,
                'rating' => 5,
                'review' => 'The performances are outstanding, making the message even more impactful. 👍🎭',
            ],
            [
                'entertainment_id' => 26,
                'user_id' => 3,
                'rating' => 4,
                'review' => 'Such a heartwarming story! It\'s a beautiful journey of love and second chances. 💖😊',
            ],
            [
                'entertainment_id' => 21,
                'user_id' => 7,
                'rating' => 5,
                'review' => 'A must-watch for history buffs! The storytelling is impeccable. 🤓🎬',
            ],
            [
                'entertainment_id' => 24,
                'user_id' => 6,
                'rating' => 5,
                'review' => 'A beautiful story of resilience and triumph against all odds. 🎥🌟',
            ],
            [
                'entertainment_id' => 20,
                'user_id' => 10,
                'rating' => 5,
                'review' => 'Perfect blend of suspense and horror. Hauntingly good! 👀🔪',
            ],
            [
                'entertainment_id' => 26,
                'user_id' => 8,
                'rating' => 5,
                'review' => 'Forever in My Heart touched my soul. It\'s a timeless love story that stays with you. 💞📽️',
            ],
            [
                'entertainment_id' => 12,
                'user_id' => 13,
                'rating' => 4,
                'review' => 'An imaginative world that brings out the child in everyone. Loved every moment! 🌈👶',
            ],
            [
                'entertainment_id' => 19,
                'user_id' => 6,
                'rating' => 4,
                'review' => 'Couldn\'t look away despite being scared out of my wits! 👀😳',
            ],
            [
                'entertainment_id' => 18,
                'user_id' => 12,
                'rating' => 5,
                'review' => 'Clever writing and great performances make this movie a joy to watch. 📝🎥',
            ],
            [
                'entertainment_id' => 12,
                'user_id' => 3,
                'rating' => 4,
                'review' => 'The New Empire sets a new standard for animated movies. Truly magical! 🌠🎉',
            ],
            [
                'entertainment_id' => 19,
                'user_id' => 9,
                'rating' => 5,
                'review' => 'Spine-chilling! Kept me awake all night. 😱👻',
            ],
            [
                'entertainment_id' => 23,
                'user_id' => 9,
                'rating' => 5,
                'review' => 'This movie reminds us that anything is possible with determination and courage. 🌟💪',
            ],
            [
                'entertainment_id' => 20,
                'user_id' => 5,
                'rating' => 5,
                'review' => 'Kept me on the edge of my seat the entire time! Terrifying twists and turns. 😱👻',
            ],
            [
                'entertainment_id' => 25,
                'user_id' => 7,
                'rating' => 5,
                'review' => 'A timeless romance that sweeps you off your feet. Pure cinematic bliss! 🎬💞',
            ],
            [
                'entertainment_id' => 21,
                'user_id' => 12,
                'rating' => 4,
                'review' => 'A fascinating exploration of ancient history, beautifully presented. 🌍🏛️',
            ],
            [
                'entertainment_id' => 20,
                'user_id' => 4,
                'rating' => 5,
                'review' => 'The atmosphere was eerie, and the scares were genuinely frightening. Bravo! 🌑🎬',
            ],
            [
                'entertainment_id' => 26,
                'user_id' => 4,
                'rating' => 5,
                'review' => 'The chemistry between the leads is undeniable. I couldn\'t stop smiling throughout! 💑🌟',
            ],
            [
                'entertainment_id' => 22,
                'user_id' => 3,
                'rating' => 5,
                'review' => 'Captivating portrayal of ancient civilizations, rich in detail and authenticity. 🏛️📜',
            ],
            [
                'entertainment_id' => 23,
                'user_id' => 3,
                'rating' => 5,
                'review' => 'Rise Above delivers a powerful message of perseverance and resilience. 🌈👏',
            ],
            [
                'entertainment_id' => 22,
                'user_id' => 8,
                'rating' => 5,
                'review' => 'A fascinating journey through history, beautifully depicted with stellar performances. 🎭🌍',
            ],
            [
                'entertainment_id' => 24,
                'user_id' => 12,
                'rating' => 3,
                'review' => 'Touching and motivational. It\'s a journey everyone should experience. 🚀😊',
            ],
            [
                'entertainment_id' => 23,
                'user_id' => 14,
                'rating' => 3,
                'review' => 'A deeply inspiring movie that touches the heart and uplifts the spirit. 🌟😊',
            ],
            [
                'entertainment_id' => 22,
                'user_id' => 9,
                'rating' => 5,
                'review' => 'Engrossing narrative that brings the past to life with every scene. 🕰️🔍',
            ],
            [
                'entertainment_id' => 23,
                'user_id' => 4,
                'rating' => 3,
                'review' => 'The storyline is moving, and the characters\' journeys are truly inspirational. 🎬❤️',
            ],
            [
                'entertainment_id' => 25,
                'user_id' => 6,
                'rating' => 3,
                'review' => 'Heartwarming and beautifully romantic, a love story that stays with you forever. 💖🌟',
            ],
            [
                'entertainment_id' => 24,
                'user_id' => 3,
                'rating' => 4,
                'review' => 'This movie inspired me deeply. A powerful reminder of the strength within us all. 🌟🙌',
            ],
            [
                'entertainment_id' => 20,
                'user_id' => 12,
                'rating' => 4,
                'review' => 'Creepy and atmospheric. It\'s a horror fan\'s dream come true! 🌌🏚️',
            ],
            [
                'entertainment_id' => 21,
                'user_id' => 3,
                'rating' => 5,
                'review' => 'An epic journey through the origins of civilization. Educational and captivating! 📚🌅',
            ],
            [
                'entertainment_id' => 25,
                'user_id' => 3,
                'rating' => 5,
                'review' => 'This movie made me believe in love all over again. Simply breathtaking! 💕😍',
            ],
            [
                'entertainment_id' => 20,
                'user_id' => 8,
                'rating' => 4,
                'review' => 'A bone-chilling experience that left me checking over my shoulder. Highly recommend! 🕯️👁️',
            ],
            [
                'entertainment_id' => 10,
                'user_id' => 12,
                'rating' => 5,
                'review' => 'Daizy\'s journey is heartwarming and filled with lessons for all ages. 🎈😊',
            ],
            [
                'entertainment_id' => 24,
                'user_id' => 7,
                'rating' => 5,
                'review' => 'The characters\' journeys are incredibly moving. You\'ll laugh, cry, and feel inspired. 💖😭',
            ],
            [
                'entertainment_id' => 19,
                'user_id' => 14,
                'rating' => 4,
                'review' => 'Every shadow feels like it\'s watching you. Thrilling till the end! 🌌👁️',
            ],
            [
                'entertainment_id' => 1,
                'user_id' => 7,
                'rating' => 5,
                'review' => 'Evokes a sense of dread and excitement simultaneously, offering a thrilling rollercoaster ride through fear and suspense. 🎢😱',
            ],
            [
                'entertainment_id' => 2,
                'user_id' => 12,
                'rating' => 4,
                'review' => 'Fantastic cinematography and thrilling gunfights! A must-watch for Western fans. 📽️🌟',
            ],
            [
                'entertainment_id' => 22,
                'user_id' => 5,
                'rating' => 5,
                'review' => 'Each moment feels like a glimpse into a forgotten era. Absolutely mesmerizing! 🌌🔮',
            ],
            [
                'entertainment_id' => 2,
                'user_id' => 13,
                'rating' => 5,
                'review' => 'Each episode is better than the last. The story is captivating and full of surprises. 🎉🚀',
            ],
            [
                'entertainment_id' => 5,
                'user_id' => 12,
                'rating' => 4,
                'review' => 'The twists and turns are brilliant. A must-watch for horror lovers! 🌫️📺',
            ],
            [
                'entertainment_id' => 4,
                'user_id' => 13,
                'rating' => 5,
                'review' => 'Edge-of-your-seat excitement and unexpected twists. Absolutely thrilling! 😱🚀',
            ],
            [
                'entertainment_id' => 10,
                'user_id' => 7,
                'rating' => 5,
                'review' => 'The animation is top-notch, and the story keeps you hooked from start to finish. 🎬💖',
            ],
            [
                'entertainment_id' => 20,
                'user_id' => 3,
                'rating' => 5,
                'review' => 'Gripping from start to finish. The tension builds up beautifully. 🎢💀',
            ],
            [
                'entertainment_id' => 25,
                'user_id' => 12,
                'rating' => 5,
                'review' => 'Touching and emotional, it captures the essence of true love\'s journey. 🌹😢',
            ],
            [
                'entertainment_id' => 1,
                'user_id' => 8,
                'rating' => 5,
                'review' => 'Captivating and spine-chilling, with a narrative that grips your imagination and leaves you pondering its mysteries. 🔍🌑',
            ],
            [
                'entertainment_id' => 4,
                'user_id' => 4,
                'rating' => 5,
                'review' => 'Great character development and intense scenes. A top-notch thriller! 👏🔥',
            ],
            [
                'entertainment_id' => 2,
                'user_id' => 14,
                'rating' => 5,
                'review' => 'The perfect blend of drama and action. The Gunslinger is a true hero! 👏🏜️',
            ],
            [
                'entertainment_id' => 11,
                'user_id' => 9,
                'rating' => 4,
                'review' => 'An enchanting journey that sparks imagination and leaves you wanting more. ✨🌟',
            ],
            [
                'entertainment_id' => 3,
                'user_id' => 9,
                'rating' => 5,
                'review' => 'The animation is stunning, and the story is captivating. Love Raziel\'s bravery! 🐉🎨',
            ],
            [
                'entertainment_id' => 26,
                'user_id' => 10,
                'rating' => 3,
                'review' => 'I cried happy tears! This movie reaffirms the power of love and hope. 💖😊',
            ],
            [
                'entertainment_id' => 3,
                'user_id' => 3,
                'rating' => 5,
                'review' => 'A magical adventure that kept my kids and me glued to the screen! 🌲✨',
            ],
            [
                'entertainment_id' => 14,
                'user_id' => 12,
                'rating' => 4,
                'review' => 'A must-watch for thriller enthusiasts. The Monkey King\'s quest will leave you wanting more. 🎭🌌',
            ],
            [
                'entertainment_id' => 18,
                'user_id' => 3,
                'rating' => 5,
                'review' => 'A comedy that hits all the right notes. Fun, light-hearted, and highly enjoyable! 🎶😊',
            ],
            [
                'entertainment_id' => 16,
                'user_id' => 6,
                'rating' => 5,
                'review' => 'The cinematography is fantastic, and the suspense never lets up. Highly recommend! 🎥🌟',
            ],
            [
                'entertainment_id' => 21,
                'user_id' => 8,
                'rating' => 4,
                'review' => 'The scale and depth of this series are truly impressive. History enthusiasts will be hooked! 🌐🔍',
            ],
            [
                'entertainment_id' => 13,
                'user_id' => 11,
                'rating' => 5,
                'review' => 'Perfect mix of fantasy and adventure. The Final Showdown was epic! ⚔️🌟',
            ],
            [
                'entertainment_id' => 19,
                'user_id' => 13,
                'rating' => 4,
                'review' => 'Heart-pounding moments that will linger long after the credits roll. Must-watch for horror enthusiasts! 🎥👹',
            ],
            [
                'entertainment_id' => 14,
                'user_id' => 6,
                'rating' => 4,
                'review' => 'Intriguing characters and stunning visual effects. A thrilling ride from start to finish. 🎬🔥',
            ],
            [
                'entertainment_id' => 12,
                'user_id' => 5,
                'rating' => 5,
                'review' => 'Heartwarming story with lovable characters. Perfect for family movie night! 🍿❤️',
            ],
            [
                'entertainment_id' => 19,
                'user_id' => 3,
                'rating' => 4,
                'review' => 'Gripping horror that leaves you checking the shadows. Not for the faint-hearted! 🚪🌚',
            ],
            [
                'entertainment_id' => 18,
                'user_id' => 4,
                'rating' => 5,
                'review' => 'A comedic adventure that keeps you smiling from start to finish. 😄🌟',
            ],
            [
                'entertainment_id' => 13,
                'user_id' => 7,
                'rating' => 5,
                'review' => 'The Hidden Fortress episode was full of unexpected twists and turns! So exciting! 🏰🔍',
            ],
            [
                'entertainment_id' => 17,
                'user_id' => 9,
                'rating' => 5,
                'review' => 'The plot is brilliantly crafted with a perfect mix of mystery and action. 📺🕵️‍♂️',
            ],
            [
                'entertainment_id' => 24,
                'user_id' => 4,
                'rating' => 4,
                'review' => 'Couldn\'t help but smile throughout. Pure comedy gold! 😊👌',
            ],
            [
                'entertainment_id' => 9,
                'user_id' => 14,
                'rating' => 5,
                'review' => 'A masterful blend of intrigue and drama. Every scene is filled with tension. 😱🏙️',
            ],
            [
                'entertainment_id' => 12,
                'user_id' => 11,
                'rating' => 4,
                'review' => 'Forever and a Day is a masterpiece in romantic storytelling. A must-watch! 🌈❤️',
            ],
            [
                'entertainment_id' => 7,
                'user_id' => 10,
                'rating' => 4,
                'review' => 'Heartfelt and uplifting. It leaves you with a sense of hope and determination. 🌈💪',
            ],
            [
                'entertainment_id' => 12,
                'user_id' => 5,
                'rating' => 5,
                'review' => 'The chemistry between the leads is magical. It\'s a love story you won\'t forget. ✨👫',
            ],
            [
                'entertainment_id' => 18,
                'user_id' => 8,
                'rating' => 4,
                'review' => 'Loved the quirky humor and unexpected twists. A must-watch for comedy lovers. 🎬🤩',
            ],

        ];
            if (env('IS_DUMMY_DATA')) {

                foreach ($reviews as $reviewData) {
                    $createdAt = Carbon::now()->subDays(rand(1, 365));
                    Review::create([
                        'entertainment_id' => $reviewData['entertainment_id'],
                        'user_id' => $reviewData['user_id'],
                        'rating' => $reviewData['rating'],
                        'review' => $reviewData['review'],
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ]);
                }

                Schema::enableForeignKeyConstraints();
            }

        }

}


