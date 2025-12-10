<?php

return [
    'title' => 'Interactive Formal Axiology Explorer',
    'subtitle' => 'A tool to understand how we measure value. Discover the principles of Robert S. Hartman\'s theory and simulate how an algorithm interprets our judgments.',
    
    'foundations_title' => 'The Foundations of Value',
    'foundations_desc' => 'Hartman\'s theory posits that we value the world through three lenses or dimensions. The "clarity" with which we use these lenses determines our capacity for judgment.',
    
    'intrinsic_title' => 'Intrinsic Value (I)',
    'intrinsic_desc' => 'Refers to the uniqueness and infinity of people. It is the value of the singular, that which is an end in itself. Measures empathy and self-esteem.',
    
    'extrinsic_title' => 'Extrinsic Value (E)',
    'extrinsic_desc' => 'It is the value of function, utility, and comparison. Applies to objects, roles, and practical actions. Measures practical judgment and role awareness.',
    
    'systemic_title' => 'Systemic Value (S)',
    'systemic_desc' => 'It is the value of order, rules, and systems. Relates to ideas, concepts, and logical constructs. Measures self-direction and abstract thinking.',
    
    'hierarchy_title' => 'The Hierarchy of Value',
    'hierarchy_desc' => 'Mathematically, an infinite (I) is "richer" than a countable infinite (E), which in turn is richer than a finite set (S). This establishes an objective hierarchy:',
    'hierarchy_s' => 'Systemic',
    'hierarchy_e' => 'Extrinsic',
    'hierarchy_i' => 'Intrinsic',

    'formulas_title' => 'The 18 Axiological Formulas',
    'formulas_desc' => 'These are the 18 combinations that form the basis of the test. They are the result of valuing each of the three dimensions (I, E, S) through the three modes of valuation.',
    'normative_rank' => 'Normative Rank',

    'psychosexual_title' => 'A Special Case: The Psychosexual Dimension',
    'psychosexual_desc' => 'This dimension, added later by Dr. Salvador Roquet, is not based on axiology but on psychodynamics. It does not measure "correctness" but coherence and internal conflicts.',
    'conflict_example_title' => 'Conflict Detection Example:',
    'conflict_example_desc' => 'The algorithm for this section does not look for deviations, but contradictory patterns. For example, if a user values very positively both...',
    'conflict_item_1' => '"I wish to love and be loved"',
    'conflict_connector' => '...and...',
    'conflict_item_2' => '"Love is hateful to me"',
    'conflict_conclusion' => '...the system does not mark it as an "error", but as a',
    'conflict_point' => 'point of internal conflict',
    'conflict_conclusion_end' => 'that deserves reflection, indicating a possible ambivalence towards intimacy.',

    'considerations_title' => 'Critical and Ethical Considerations',
    'considerations_desc' => 'Developing an application of this type carries significant legal and ethical responsibilities.',
    
    'cons_ip_title' => 'Intellectual Property and Copyright',
    'cons_ip_content' => 'The Hartman Value Profile is a copyright-protected instrument. Copying its items is an infringement. The only legal way is to create a new instrument based on Hartman\'s public theory, using the 18 formulas to generate original items. The application must be marketed as "Based on Hartman\'s Formal Axiology", not as the official test.',
    
    'cons_standards_title' => 'Psychological Assessment Standards',
    'cons_standards_content' => 'An automated application does not replace a qualified professional. It should not claim to diagnose psychological conditions. It must be clearly positioned as an educational or self-knowledge tool, not a clinical evaluation. Automated results should not be the sole basis for important decisions.',
    
    'cons_privacy_title' => 'Data Privacy and Consent',
    'cons_privacy_content' => 'The application must comply with regulations like GDPR, handling sensitive data securely (encryption, secure storage). Before starting, clear informed consent must be presented, explaining what data is collected, how it is used, risks, and limitations of the assessment.',
    
    'cons_disclaimer_title' => 'Disclaimer',
    'cons_disclaimer_content' => 'A visible disclaimer is essential stating: 1. Educational purposes only. 2. Not medical or psychological advice. 3. No guarantees on results. 4. Personal responsibility lies with the user. 5. Must include links to crisis help resources.',

    // Formulas descriptions
    'formula_Ii_name' => 'A baby', 'formula_Ii_desc' => 'Valuing the Intrinsic intrinsically.',
    'formula_Ie_name' => 'Love of nature', 'formula_Ie_desc' => 'Valuing the Intrinsic extrinsically.',
    'formula_Is_name' => 'By this ring I thee wed', 'formula_Is_desc' => 'Valuing the Intrinsic systemically.',
    'formula_Ei_name' => 'A devoted scientist', 'formula_Ei_desc' => 'Valuing the Extrinsic intrinsically.',
    'formula_Ee_name' => 'A good meal', 'formula_Ee_desc' => 'Valuing the Extrinsic extrinsically.',
    'formula_Es_name' => 'An assembly line', 'formula_Es_desc' => 'Valuing the Extrinsic systemically.',
    'formula_Si_name' => 'A genius', 'formula_Si_desc' => 'Valuing the Systemic intrinsically.',
    'formula_Se_name' => 'A technical improvement', 'formula_Se_desc' => 'Valuing the Systemic extrinsically.',
    'formula_Ss_name' => 'A uniform', 'formula_Ss_desc' => 'Valuing the Systemic systemically.',
    'formula_-Ss_name' => 'A nonsensical idea', 'formula_-Ss_desc' => 'Disvaluing the Systemic systemically.',
    'formula_-Se_name' => 'A fine', 'formula_-Se_desc' => 'Disvaluing the Systemic extrinsically.',
    'formula_-Si_name' => 'Blow up an airliner', 'formula_-Si_desc' => 'Disvaluing the Systemic intrinsically.',
    'formula_-Es_name' => 'A short circuit', 'formula_-Es_desc' => 'Disvaluing the Extrinsic systemically.',
    'formula_-Ee_name' => 'Rubbish', 'formula_-Ee_desc' => 'Disvaluing the Extrinsic extrinsically.',
    'formula_-Ei_name' => 'A madman', 'formula_-Ei_desc' => 'Disvaluing the Extrinsic intrinsically.',
    'formula_-Is_name' => 'Burn a heretic', 'formula_-Is_desc' => 'Disvaluing the Intrinsic systemically.',
    'formula_-Ie_name' => 'Slavery', 'formula_-Ie_desc' => 'Disvaluing the Intrinsic extrinsically.',
    'formula_-Ii_name' => 'Torture a person', 'formula_-Ii_desc' => 'Disvaluing the Intrinsic intrinsically.',
];
