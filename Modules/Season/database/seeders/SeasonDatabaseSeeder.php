<?php

namespace Modules\Season\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Modules\Season\Models\Season;
use Illuminate\Support\Facades\Storage;

class SeasonDatabaseSeeder extends Seeder
{

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $seasons = [
            [
                'name' => 'S1 The Awakening Shadows',
                'entertainment_id' => 1,
                'poster_url' => '/dummy-images/episode/s1_the_awakening_shadows_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s1_the_awakening_shadows_thumb.png',
                'short_desc' => 'The team battles an ancient evil that awakens from the shadows. 🌒',
                'description' => 'The team encounters a series of mysterious events that awaken an ancient evil. Their battle to understand and confront this malevolent force begins. 🏚️👻',
                'trailer_url' => 'https://youtu.be/1sCBEzxF_K4?si=B-rZUby9EXaMWkKD',
                'trailer_url_type' => 'YouTube',
                'access' => 'free',
                'status' => 1,
            ],
            [
                'name' => 'S2 The Rising Shadows',
                'entertainment_id' => 1,
                'poster_url' => '/dummy-images/episode/s2_the_rising_shadows_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s2_the_rising_shadows_thumb.png',
                'short_desc' => 'Darkness intensifies as the ancient evil returns, stronger than before.',
                'description' => 'As the ancient evil rises again, the team faces even darker and more powerful threats. They must confront their deepest fears to save humanity from eternal darkness. 🌑🛡️',
                'trailer_url' => 'https://youtu.be/7_MJp5AbSwA?si=Mtx9h0wlxtn4o_2Q',
                'trailer_url_type' => 'YouTube',
                'access' => 'free',
                'status' => 1,
            ],
            [
                'name' => 'S1 Lawless Frontier',
                'entertainment_id' => 2,
                'poster_url' => '/dummy-images/episode/s1_lawless_frontier_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s1_lawless_frontier_thumb.png',
                'short_desc' => 'The Gunslinger returns to a chaotic town, battling ruthless outlaws and his own demons to restore justice. 🤠🔥',
                'description' => 'A legendary gunslinger rides back into town, where chaos and corruption reign. Determined to rid the land of crime and find redemption for his troubled past, he faces off against ruthless outlaws and must confront his own inner demons. As the battle for justice unfolds, the town’s fate hangs in the balance, and the gunslinger’s resolve is tested like never before. 🌵⚔️',
                'trailer_url' => 'https://youtu.be/iABaiZO5Vjs?si=-86t28oJD4cIwkY0',
                'trailer_url_type' => 'YouTube',
                'access' => 'paid',
                'plan_id' => 1,
                'status' => 1,
            ],
            [
                'name' => 'S1 The Journey Begins',
                'entertainment_id' => 3,
                'poster_url' => '/dummy-images/episode/s1_the_journey_begins_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s1_the_journey_begins_thumb.png',
                'short_desc' => 'Follow Raziel\'s first steps on a heroic quest to save his friend from the clutches of the wicked Gothel. 🏞️✨',
                'description' => 'Follow the young and courageous Raziel as he embarks on a heroic quest to save his friend from the clutches of the wicked Gothel. This season chronicles Raziel\'s initial steps into the enchanted forest, where he encounters magical creatures, forms new alliances, and faces the first of many trials. Through determination, bravery, and a growing sense of self-discovery, Raziel begins to uncover the true extent of Gothel\'s sinister plans. Join Raziel on this enchanting journey filled with adventure, mystery, and the unyielding spirit of a true hero. 🏞️✨',
                'trailer_url' => 'https://youtu.be/yGkGMzupaVs?si=O0EBto49niZjBm_e',
                'trailer_url_type' => 'YouTube',
                'access' => 'paid',
                'plan_id' => 2,
                'status' => 1,
            ],
            [
                'name' => 'S2 Trials and Triumphs',
                'entertainment_id' => 3,
                'poster_url' => '/dummy-images/episode/s2_trials_and_triumphs_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s2_trials_and_triumphs_thumb.png',
                'short_desc' => 'Raziel faces greater challenges and uncovers deeper secrets as he continues his daring rescue mission. 🏰⚔️',
                'description' => 'Raziel\'s quest intensifies as he delves deeper into the heart of Gothel\'s domain. This season is marked by greater challenges, deeper secrets, and high-stakes confrontations. Raziel and his allies must navigate treacherous landscapes, solve intricate puzzles, and battle formidable foes. As they uncover the layers of Gothel\'s dark magic, Raziel\'s resolve and skills are tested like never before. The season builds to a thrilling climax as Raziel confronts Gothel in a final showdown, determined to rescue his friend and bring peace to the land. Experience the trials and triumphs that define a hero\'s journey in this captivating continuation of Raziel\'s adventure. 🏰⚔️',
                'trailer_url' => 'https://youtu.be/0R3YS_k6a5E?si=hu-eCRA6KQFfIEg2',
                'trailer_url_type' => 'YouTube',
                'access' => 'paid',
                'plan_id' => 2,
                'status' => 1,
            ],
            [
                'name' => 'S1 The Hunt Begins',
                'entertainment_id' => 4,
                'poster_url' => '/dummy-images/episode/s1_the_hunt_begins_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s1_the_hunt_begins_thumb.png',
                'short_desc' => 'A relentless detective embarks on a dark quest to track down a cunning criminal mastermind. 🔍🕵️‍♂️',
                'description' => 'The Hunt Begins follows Detective James Black as he dives into a labyrinth of crime and deceit, pursuing the elusive criminal known only as The Phantom. With each clue, the mystery deepens, leading to shocking revelations and deadly encounters. As James races against time, he discovers that the chase is personal, and failure is not an option. 🔍🕵️‍♂️',
                'trailer_url' => 'https://youtu.be/4IByYWqUrvM?si=ikragPXgMAAECJw8',
                'trailer_url_type' => 'YouTube',
                'access' => 'paid',
                'plan_id' => 3,
                'status' => 1,
            ],
            [
                'name' => 'S2 The Phantom Strikes Back',
                'entertainment_id' => 4,
                'poster_url' => '/dummy-images/episode/s2_the_phantom_strikes_back_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s2_the_phantom_strikes_back_thumb.png',
                'short_desc' => 'The Phantom returns, setting off a deadly game of cat and mouse with Detective Black. 🕵️‍♂️💥',
                'description' => 'The stakes are higher and the danger more imminent. Detective Black faces new challenges as The Phantom resurfaces, orchestrating a series of crimes that push the city to the brink. James must outwit his nemesis in a battle of wits and wills, uncovering secrets that could change everything. The tension mounts as the line between hunter and hunted blurs. 🕵️‍♂️💥',
                'trailer_url' => 'https://youtu.be/T5UokLYVJMI?si=7DVFmcXSmf5zVGKj',
                'trailer_url_type' => 'YouTube',
                'access' => 'paid',
                'plan_id' => 3,
                'status' => 1,
            ],
            [
                'name' => 'S1 The Shrouded Beginnings',
                'entertainment_id' => 5,
                'poster_url' => '/dummy-images/episode/s1_the_shrouded_beginnings_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s1_the_shrouded_beginnings_thumb.png',
                'short_desc' => 'Explore the terrifying mysteries of a town shrouded in darkness as unseen forces strike. 🌑👻',
                'description' => 'The Shrouded Beginnings explores the eerie origins of Ravenwood, where ancient and malevolent forces begin to awaken. As strange occurrences and ghostly apparitions plague the town, a group of determined residents sets out to uncover the truth behind the growing darkness. Their journey reveals chilling secrets and tests their courage as they delve into the heart of the town\'s haunted past. 🌑🕯️',
                'trailer_url' => 'https://youtu.be/h1miqLzgKp0?si=5PYD5oOv2MwxwEvw',
                'trailer_url_type' => 'YouTube',
                'access' => 'paid',
                'plan_id' => 4,
                'status' => 1,
            ],
            [
                'name' => 'S2 The Deepening Shadows',
                'entertainment_id' => 5,
                'poster_url' => '/dummy-images/episode/s2_the_deepening_shadows.png',
                'poster_tv_url' => '/dummy-images/episode/s2_the_deepening_shadows.png',
                'short_desc' => 'Darkness intensifies, and the struggle for survival grows fiercer. 🌘⚔️',
                'description' => 'The Deepening Shadows sees the malevolent forces in Ravenwood growing stronger and more vengeful. The residents, now armed with knowledge from their previous encounters, must face even greater horrors. As they delve deeper into the town\'s haunted history, they uncover shocking truths and form unlikely alliances to combat the rising evil. The struggle for survival reaches a critical point, pushing the residents to their limits and revealing the true extent of their bravery. 🌘⚔️',
                'trailer_url' => 'https://youtu.be/dt8gBF1uZ3E?si=AI2JENWIAUD_SKmr',
                'trailer_url_type' => 'YouTube',
                'access' => 'paid',
                'plan_id' => 4,
                'status' => 1,
            ],
            [
                'name' => 'S1 Whispers of Betrayal',
                'entertainment_id' => 6,
                'poster_url' => '/dummy-images/episode/s1_whispers_of_betrayal_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s1_whispers_of_betrayal_thumb.png',
                'short_desc' => 'A relentless investigator uncovers hidden truths and faces betrayals that threaten to unravel everything. 🔍🕵️‍♂️',
                'description' => 'Whispers of Betrayal follows Investigator Alex Reed as he dives into a labyrinth of hidden truths and deception. As he uncovers layers of betrayal that cut close to home, he realizes that the people he trusts most might be hiding the darkest secrets. The season is a gripping tale of trust, treachery, and the relentless pursuit of justice. 🔍🕵️‍♂️',
                'trailer_url' => 'https://youtu.be/kWTcFa0DEl0?si=zTjxDCxXXqOLB29F',
                'trailer_url_type' => 'YouTube',
                'access' => 'free',
                'status' => 1,
            ],
            [
                'name' => 'S1 The Darkened Path',
                'entertainment_id' => 7,
                'poster_url' => '/dummy-images/episode/s1_the_darkened_path_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s1_the_darkened_path_thumb.png',
                'short_desc' => 'Emily steps onto the darkened path, discovering the haunted legacy of her grandmother, Dorothy, as she navigates the dangerous and decayed world of Oz.',
                'description' => 'In "The Darkened Path", Emily Gale\'s world is turned upside down when she stumbles upon her family\'s long-hidden connection to the mystical realm of Oz. But this is not the Oz of fairy tales—this is a twisted, shadow-filled land where nightmares come alive. As Emily sets out on a harrowing journey down the forgotten road, she must unravel the secrets of her grandmother\'s past, confront terrifying creatures, and uncover the truth about the curse that binds her family to this darkened path. The stakes are high, and survival is uncertain in this thrilling first series. 🌪️🖤',
                'trailer_url' => 'https://youtu.be/PI4Z7t3AZ5E?si=QNKYohZ1ZgLol_OP',
                'trailer_url_type' => 'YouTube',
                'access' => 'paid',
                'plan_id' => 1,
                'status' => 1,
            ],
            [
                'name' => 'S2 The Curse Unveiled',
                'entertainment_id' => 7,
                'poster_url' => '/dummy-images/episode/s2_the_curse_unveiled_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s2_the_curse_unveiled_thumb.png',
                'short_desc' => 'Emily returns to Oz as rising shadows threaten to consume both worlds, forcing her into a final confrontation with the ancient evil that haunts her bloodline.',
                'description' => 'Emily, still haunted by the horrors of her first journey, is pulled back into the decaying world of Oz. This time, the shadows have grown stronger, their influence spreading into her own reality. With new allies and old enemies lurking in the darkness, Emily faces her greatest challenge yet: to stop an ancient evil from fully awakening. As the lines between the real world and Oz blur, Emily must summon all her strength to fight the rising shadows and end the family curse once and for all. 🌑⚡💀',
                'trailer_url' => 'https://youtu.be/W0_55mECsa4?si=b_AlIpdvNC_wZ5Zr',
                'trailer_url_type' => 'YouTube',
                'access' => 'paid',
                'plan_id' => 1,
                'status' => 1,
            ],
            [
                'name' => 'S1 The Wild Awakening',
                'entertainment_id' => 8,
                'poster_url' => '/dummy-images/episode/s1_the_wild_awakening_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s1_the_wild_awakening_thumb.png',
                'short_desc' => '🌕 Maddy and Rhydian discover their true natures as they fight to protect their identities from hunters and rival wolfbloods. 👩',
                'description' => '🌕 Maddy’s world is turned upside down when Rhydian enters her life, sparking a journey of self-discovery and adventure. Together, they must navigate the challenges of being wolfbloods—hunted by those who fear them and rivaled by those who threaten them. As their powers grow, so does the danger around them. Rhydian’s mysterious past and Maddy’s loyalty to her pack will be tested in a thrilling fight for survival. 🐺🔥⚡ This action-packed series offers excitement, drama, and emotional depth, making Wolfbound an epic journey for fans of adventure and mystery.',
                'trailer_url' => 'https://youtu.be/iJkspWwwZLM?si=chtl8vdmLqPNKPfE',
                'trailer_url_type' => 'YouTube',
                'access' => 'free',
                'plan_id' => null,
                'status' => 1,
            ],
            [
                'name' => 'S1 Rise of the Tribes',
                'entertainment_id' => 9,
                'poster_url' => '/dummy-images/episode/s1_rise_of_the_tribes_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s1_rise_of_the_tribes_thumb.png',
                'short_desc' => '🌍 The tribes unite for the first time as a powerful enemy threatens to destroy their homeland, forcing them to rise up together in a battle for survival.',
                'description' => '🔥 The tribes scattered and divided, but when a brutal force of invaders descends upon their land, they must set aside old rivalries and forge a new alliance. The story follows warriors from different tribes as they band together, learning to trust one another while navigating ancient prophecies, mysterious allies, and dangerous enemies. As they face impossible odds, the tribes grow stronger, discovering that unity is their greatest weapon. This season sets the stage for an epic war that will determine the fate of their people and homeland. ⚔️🐾🛡️',
                'trailer_url' => 'https://youtu.be/MAFsRmx6pPo?si=CJjoeRbHVtKJt9oC',
                'trailer_url_type' => 'YouTube',
                'access' => 'free',
                'plan_id' => null,
                'status' => 1,
            ],
            [
                'name' => 'S1 Warrior’s End',
                'entertainment_id' => 10,
                'poster_url' => '/dummy-images/episode/s1_warriors_end_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s1_warriors_end_thumb.png',
                'short_desc' => '🛡️ "Warrior’s End" captures the final, defining moments of legendary battles where valor and sacrifice shape the destiny of heroes and their world.',
                'description' => '⚔️ "Warrior’s End" is a gripping series that delves into the climactic endgame of legendary conflicts. Following a series of monumental battles, the show focuses on the warriors who stand at the crossroads of history. As they face their final tests of bravery, strategy, and sacrifice, the series highlights their pivotal roles in shaping the fate of their world. Through intense action sequences and deep character development, "Warrior’s End" explores the essence of heroism and the enduring impact of those who fight for honor and freedom. Each episode unveils the final chapters of epic sagas, celebrating the courage and legacy of those who determined the course of history. 🌄🔥🛡️',
                'trailer_url' => 'https://youtu.be/-Denciie5oA?si=GBZdawncCJfXbjWk',
                'trailer_url_type' => 'YouTube',
                'access' => 'paid',
                'plan_id' => 4,
                'status' => 1,
            ],
            [
                'name' => 'S1 Tides of War',
                'entertainment_id' => 11,
                'poster_url' => '/dummy-images/episode/s1_tides_of_war_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s1_tides_of_war_thumb.png',
                'short_desc' => '🔥 "Tides of War" unravels the turning points of history’s most critical battles, where strategy, technology, and sheer willpower shape the outcome of empires and civilizations. 🌍⚔️',
                'description' => '"Tides of War" captures the ebb and flow of monumental military campaigns that have reshaped the course of history. The series focuses on critical moments when innovation, leadership, and determination collide in the face of overwhelming odds. As armies clash and powerful technologies are unleashed, heroes rise from the chaos, forging new paths and legacies. Whether in the heat of modern warfare or amidst futuristic apocalyptic threats, "Tides of War" examines the high stakes, the human cost, and the lasting impact of these pivotal battles. 🌍⚔️🔥🛡️',
                'trailer_url' => 'https://youtu.be/Cg8sbRFS3zU?si=lB_55d61yMCtZ1bx',
                'trailer_url_type' => 'YouTube',
                'access' => 'free',
                'plan_id' => null,
                'status' => 1,
            ],
            [
                'name' => 'S1 Into the Abyss',
                'entertainment_id' => 12,
                'poster_url' => '/dummy-images/episode/s1_into_the_abyss_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s1_into_the_abyss_thumb.png',
                'short_desc' => 'The team descends into the Earth’s core, unveiling ancient secrets and battling unknown forces in their quest to unlock the mysteries of the planet\'s inner depths. 🌋🌪️',
                'description' => '"Into the Abyss," kicks off the thrilling adventure as a team of expert geologists, archaeologists, and military personnel dive into the unknown, heading deep into the Earth\'s core. What they discover beneath the surface challenges everything they thought they knew about human history. As they journey through vast underground caverns and encounter remnants of lost civilizations, they also find themselves in the crosshairs of a hidden empire determined to protect its ancient secrets. The deeper they go, the higher the stakes become, as the team must not only survive the physical dangers of the subterranean world but also unravel the mysteries that could alter the fate of humankind. This season is filled with relentless action, high stakes, and breathtaking discoveries. 🌍🛡️💥',
                'trailer_url' => 'https://youtu.be/rcsMELh_3TA?si=lvKpb3FsVt7_-SEZ',
                'trailer_url_type' => 'YouTube',
                'access' => 'paid',
                'plan_id' => 1,
                'status' => 1,
            ],
            [
                'name' => 'S1 Blades of Espionage',
                'entertainment_id' => 13,
                'poster_url' => '/dummy-images/episode/s1_blades_of_espionage_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s1_blades_of_espionage_thumb.png',
                'short_desc' => 'A former special ops agent-turned-barber is pulled back into the world of espionage, where each haircut unravels a dangerous web of secrets and spies. ✂️💈🕵️‍♂️💥',
                'description' => 'Cutting Edge: Blades of Espionage follows Ethan, a once-decorated special ops agent who now leads a quiet life as a barber. However, his shop is a front for high-stakes international intrigue, as his clients range from spies to assassins, all bringing their secrets to his chair. When a new threat arises, Ethan is pulled back into the world of covert missions, forced to wield his blade both for hair and for survival. Balancing his dual identities, Ethan navigates a dangerous game where every snip of the scissors could be his last. This action-packed series combines sharp wit, intense drama, and stylish espionage. ✂️🕵️‍♂️💥',
                'trailer_url' => 'https://youtu.be/dKkT8_RGDYg?si=4gdepK-sTlGcxcPw',
                'trailer_url_type' => 'YouTube',
                'access' => 'paid',
                'plan_id' => 3,
                'status' => 1,
            ],
            [
                'name' => 'S2 The Cutthroat Mission',
                'entertainment_id' => 13,
                'poster_url' => '/dummy-images/episode/s2_the_cutthroat_mission_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s2_the_cutthroat_mission_thumb.png',
                'short_desc' => 'Ethan, a former agent turned barber, is dragged back into the deadly world of espionage, where every haircut holds a secret and every enemy lurks in the shadows. 💈✂️🕵️‍♂️',
                'description' => 'In the first series, "Snip & Spy: The Razor\'s Edge," Ethan\'s quiet life as a barber is shattered when his past comes back to haunt him. His once-thriving salon becomes the center of a high-stakes operation involving covert agents, hidden microchips, and an old nemesis intent on destroying him. Forced to rely on his barber tools and combat skills, Ethan must outwit dangerous enemies, protect his clients, and solve a mystery that leads him deep into the world of espionage. Packed with adrenaline-pumping action, clever humor, and a unique mix of barbershop charm and spy drama, "The Razor\'s Edge" will keep viewers on the edge of their seats. ✂️💣⚔️',
                'trailer_url' => 'https://youtu.be/-Qv6p6pTz5I?si=aeaLICb9s9VAgl4W',
                'trailer_url_type' => 'YouTube',
                'access' => 'paid',
                'plan_id' => 3,
                'status' => 1,
            ],
            [
                'name' => 'S1 Mending Tides',
                'entertainment_id' => 14,
                'poster_url' => '/dummy-images/episode/s1_mending_tides_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s1_mending_tides_thumb.png',
                'short_desc' => 'Three estranged sisters embark on a transformative road trip along the Pacific Coast, mending broken family bonds as they confront their troubled past. 🚗💔🌊',
                'description' => 'In Mending Tides, June Stevenson leads her estranged sisters on an unforgettable road trip along the Pacific Coast, determined to reconcile with their difficult father and heal old wounds. As they navigate breathtaking landscapes, lively pit stops, and the emotional currents of their past, the sisters begin to uncover hidden truths about their fractured family. Through laughter, heartache, and unexpected adventures, they realize that the journey toward forgiveness may be as important as the destination. Mending Tides is an inspiring tale of sisterhood, healing, and the courage to face one\'s past. 🌊💞🌅',
                'trailer_url' => 'https://youtu.be/5eQKOr6sFgk?si=aGYzXoiBPFTf1XtA',
                'trailer_url_type' => 'YouTube',
                'access' => 'free',
                'plan_id' => null,
                'status' => 1,
            ],
            [
                'name' => 'S1 The McDoll Chronicles',
                'entertainment_id' => 15,
                'poster_url' => '/dummy-images/episode/s1_the_mcdoll_chronicles_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s1_the_mcdoll_chronicles_thumb.png',
                'short_desc' => 'Follow the uproarious journey of David McDoll as he navigates the chaos of inheriting six lively grandchildren, discovering the true meaning of family amidst the hilarity. 🏠👨‍👩‍👧‍👦🤣',
                'description' => 'The McDoll Chronicles takes you on a side-splitting journey with David McDoll, a wealthy and self-indulgent man whose life is turned upside down when he suddenly becomes the guardian of his six boisterous grandchildren. As his extravagant lifestyle collides with the rambunctious energy of his new family members, David faces a whirlwind of comedic escapades and heartfelt moments. Through chaotic family dinners, wild adventures, and touching revelations, David learns the true value of family and finds joy in the mayhem. This series is a heartwarming and hilarious exploration of how unexpected changes can lead to the most rewarding experiences. 🏰💖😂',
                'trailer_url' => 'https://youtu.be/X0K5cA2hS6g?si=dCiATYDWrJmKK86q',
                'trailer_url_type' => 'YouTube',
                'access' => 'free',
                'plan_id' => null,
                'status' => 1,
            ],
            [
                'name' => 'S1 Secrets Beneath the Surface',
                'entertainment_id' => 16,
                'poster_url' => '/dummy-images/episode/s1_secrets_beneath_the_surface_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s1_secrets_beneath_the_surface_thumb.png',
                'short_desc' => 'As their romance grows, both must face their hidden pasts and unravel the mysteries that bind them, learning that love requires trust and vulnerability. 🗝️❤️🌹',
                'description' => 'In "Secrets Beneath the Surface", the first season of "Enigma of the Heart", the focus is on the deepening relationship between the playboy journalist and the enigmatic model. Their love begins with intrigue and attraction but soon evolves into something more profound as both of them are forced to confront the secrets they’ve been hiding. As their worlds collide, they must navigate the emotional and moral complexities of their double lives, learning that trust and vulnerability are key to unlocking true love. Along the way, they discover that love is not just about passion—it’s about embracing one’s flaws and finding redemption through the power of connection. 🗝️❤️🌹',
                'trailer_url' => 'https://youtu.be/qfyF0HmRv_0?si=s27BZDReq7BD4f7M',
                'trailer_url_type' => 'YouTube',
                'access' => 'paid',
                'plan_id' => 1,
                'status' => 1,
            ],
            [
                'name' => 'S1 The Haunting of Blackthorn Manor',
                'entertainment_id' => 17,
                'poster_url' => '/dummy-images/episode/s1_the_haunting_of_blackthorn_manor_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s1_the_haunting_of_blackthorn_manor_thumb.png',
                'short_desc' => 'Father James returns to Blackthorn Manor, where he must face terrifying spirits and his deepest fears in a fight for his soul. 👻🏚️',
                'description' => '"The Haunting of Blackthorn Manor" kicks off with Father James returning to the eerie mansion that haunts his memories. The season focuses on James’ night in Blackthorn Manor, where the spirits of the girl and her stepfather torment him, forcing him to confront the tragedy he could not prevent. Each episode deepens the psychological tension as James battles to keep his sanity while uncovering the truth about the mansion\'s dark history. As the supernatural forces grow stronger, so too does his need for redemption, but the path is fraught with danger and terror. This season blends supernatural thrills with intense emotional drama as Father James seeks salvation in the face of overwhelming darkness. 👻🏚️🕯️',
                'trailer_url' => 'https://youtu.be/UEJuNHOd8Dw?si=xMwHr2S-WM2Aautr',
                'trailer_url_type' => 'YouTube',
                'access' => 'paid',
                'plan_id' => 1,
                'status' => 1,
            ],
            [
                'name' => 'S1 Roots and Revelations',
                'entertainment_id' => 18,
                'poster_url' => '/dummy-images/episode/s1_roots_and_revelations_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s1_roots_and_revelations_thumb.png',
                'short_desc' => 'The main character begins his comedic journey of cultural discovery, leading to laugh-out-loud clashes between his upbringing and newfound understanding of his heritage. 👪🎭',
                'description' => 'The first season of "Heritage Hijinks," titled "Roots and Revelations," takes viewers on a rollercoaster ride through the life of the main character as he seeks to reconnect with his African American roots while navigating the humorous differences between his liberal white upbringing and the cultural identity he\'s discovering. With his quirky best friend by his side, every family dinner turns into a comedy show of contrasting beliefs, while each new experience brings both laughter and deeper self-awareness. As their cultural explorations continue, this season sets the tone for a series full of heart, humor, and acceptance. 🎉🌍👫',
                'trailer_url' => 'https://youtu.be/7lSzGK5HR1M?si=ltOK7kx6m3IIWv2b',
                'trailer_url_type' => 'YouTube',
                'access' => 'free',
                'plan_id' => null,
                'status' => 1,
            ],
            [
                'name' => 'S1 The Unleashing',
                'entertainment_id' => 19,
                'poster_url' => '/dummy-images/episode/s1_the_unleashing_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s1_the_unleashing_thumb.png',
                'short_desc' => 'A cursed relic releases terrifying demons upon an unsuspecting city. A group of survivors must fight to survive as evil forces threaten to consume them. 🏙️👹',
                'description' => '"Evil Awakening" titled "The Unleashing," a group of young adults inadvertently awakens ancient, flesh-hungry demons by uncovering the cursed Necronomicon. Moving from the deep woods to the sprawling cityscape, the horrors quickly spread, turning their once-familiar environment into a nightmare. Two estranged sisters, reunited in the face of terror, must put aside their differences and team up with others to survive the rise of the demons. The season escalates into a series of terrifying confrontations, as they are hunted by the most horrifying incarnation of evil imaginable. From haunted buildings to nightmarish alleyways, "The Unleashing" will keep viewers on edge as the group battles to break the curse and prevent the total destruction of their world. 😨📖',
                'trailer_url' => 'https://youtu.be/j2Fec39AHJ8?si=c9WEIe5NXoF_tmrE',
                'trailer_url_type' => 'YouTube',
                'access' => 'free',
                'plan_id' => null,
                'status' => 1,
            ],
            [
                'name' => 'S1 The Reckoning Retreat',
                'entertainment_id' => 20,
                'poster_url' => '/dummy-images/episode/s1_the_reckoning_retreat_thumb.png',
                'poster_tv_url' => '/dummy-images/episode/s1_the_reckoning_retreat_thumb.png',
                'short_desc' => 'A peaceful cabin retreat for four friends spirals into a suspense-filled nightmare when they discover something sinister lurking in the woods. 🌲👻',
                'description' => '"The Reckoning Retreat", four old friends—Esme, Hannah, Ben, and Shan—attempt to reconnect during a weekend getaway at a secluded cabin. Their hopes for peace and bonding are quickly dashed when they discover they are not alone. As unsettling events unfold, the group\'s old wounds resurface, and deep-seated secrets emerge. The quiet wilderness turns into a dark, foreboding setting as they realize something—or someone—is watching them. Each episode escalates the tension as the friends confront both the external threat and their inner demons. Survival becomes paramount as they uncover the truth about the sinister force stalking them. 😱🌲🔍',
                'trailer_url' => 'https://youtu.be/bvDArsKoTOE?si=bfxIZyuVGNqpdu81',
                'trailer_url_type' => 'YouTube',
                'access' => 'free',
                'plan_id' => null,
                'status' => 1,
            ]




        ];

        if (env('IS_DUMMY_DATA')) {
            foreach ($seasons as $mediaData) {
                $posterPath = $mediaData['poster_url'] ?? null;
                $posterTvPath = $mediaData['poster_tv_url'] ?? null;

                $media = Season::create(Arr::except($mediaData, ['poster_url','poster_tv_url']));

                if (isset($posterPath)) {
                    $posterUrl = $this->uploadToSpaces($posterPath);
                    if ($posterUrl) {
                        $media->poster_url = extractFileNameFromUrl($posterUrl);
                    }
                }
                if (isset($posterTvPath)) {
                    $posterTvUrl = $this->uploadToSpaces($posterTvPath);
                    if ($posterTvUrl) {
                        $media->poster_tv_url = extractFileNameFromUrl($posterTvUrl);
                    }
                }

                $media->save();
            }

            Schema::enableForeignKeyConstraints();
        }
    }

    private function uploadToSpaces($publicPath)
    {
        $localFilePath = public_path($publicPath);
        $remoteFilePath = 'streamit-laravel/' . basename($publicPath);

        if (file_exists($localFilePath)) {
            // Get the active storage disk from the environment
            $disk = env('ACTIVE_STORAGE', 'local');

            if ($disk === 'local') {
                // Store in the public directory for local storage
                Storage::disk($disk)->put('public/' . $remoteFilePath, file_get_contents($localFilePath));
                return asset('storage/' . $remoteFilePath);
            } else {
                // Upload to the specified storage disk
                Storage::disk($disk)->put($remoteFilePath, file_get_contents($localFilePath));
                return Storage::disk($disk)->url($remoteFilePath);
            }
        }

        return false;
    }


}
