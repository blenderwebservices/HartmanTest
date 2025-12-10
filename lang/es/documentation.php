<?php

return [
    'title' => 'Explorador Interactivo de la Axiología Formal',
    'subtitle' => 'Una herramienta para entender cómo medimos el valor. Descubre los principios de la teoría de Robert S. Hartman y simula cómo un algoritmo interpreta nuestros juicios.',
    
    'foundations_title' => 'Los Fundamentos del Valor',
    'foundations_desc' => 'La teoría de Hartman postula que valoramos el mundo a través de tres lentes o dimensiones. La "claridad" con que usamos estas lentes determina nuestra capacidad de juicio.',
    
    'intrinsic_title' => 'Valor Intrínseco (I)',
    'intrinsic_desc' => 'Se refiere a la unicidad e infinidad de las personas. Es el valor de lo singular, lo que es un fin en sí mismo. Mide la empatía y la autoestima.',
    
    'extrinsic_title' => 'Valor Extrínseco (E)',
    'extrinsic_desc' => 'Es el valor de la función, la utilidad y la comparación. Se aplica a objetos, roles y acciones prácticas. Mide el juicio práctico y el sentido de rol.',
    
    'systemic_title' => 'Valor Sistémico (S)',
    'systemic_desc' => 'Es el valor del orden, las reglas y los sistemas. Se relaciona con ideas, conceptos y construcciones lógicas. Mide la autodirección y el pensamiento abstracto.',
    
    'hierarchy_title' => 'La Jerarquía del Valor',
    'hierarchy_desc' => 'Matemáticamente, un infinito (I) es "más rico" que un infinito numerable (E), que a su vez es más rico que un conjunto finito (S). Esto establece una jerarquía objetiva:',
    'hierarchy_s' => 'Sistémico',
    'hierarchy_e' => 'Extrínseco',
    'hierarchy_i' => 'Intrínseco',

    'formulas_title' => 'Las 18 Fórmulas Axiológicas',
    'formulas_desc' => 'Estas son las 18 combinaciones que forman la base de la prueba. Son el resultado de valorar cada una de las tres dimensiones (I, E, S) a través de los tres modos de valoración.',
    'normative_rank' => 'Rango Normativo',

    'psychosexual_title' => 'Un Caso Especial: La Dimensión Psicosexual',
    'psychosexual_desc' => 'Esta dimensión, añadida posteriormente por el Dr. Salvador Roquet, no se basa en la axiología, sino en la psicodinámica. No se mide la "corrección", sino la coherencia y los conflictos internos.',
    'conflict_example_title' => 'Ejemplo de Detección de Conflicto:',
    'conflict_example_desc' => 'El algoritmo para esta sección no busca desviaciones, sino patrones contradictorios. Por ejemplo, si un usuario valora muy positivamente tanto...',
    'conflict_item_1' => '"Yo deseo amar y ser amado"',
    'conflict_connector' => '...como...',
    'conflict_item_2' => '"El amor es odioso para mí"',
    'conflict_conclusion' => '...el sistema no lo marca como un "error", sino como un',
    'conflict_point' => 'punto de conflicto interno',
    'conflict_conclusion_end' => 'que merece reflexión, indicando una posible ambivalencia hacia la intimidad.',

    'considerations_title' => 'Consideraciones Críticas y Éticas',
    'considerations_desc' => 'El desarrollo de una aplicación de este tipo conlleva importantes responsabilidades legales y éticas.',
    
    'cons_ip_title' => 'Propiedad Intelectual y Derechos de Autor',
    'cons_ip_content' => 'El Perfil de Valores de Hartman es un instrumento protegido por derechos de autor. Copiar sus ítems es una infracción. La única vía legal es crear un nuevo instrumento basado en la teoría pública de Hartman, utilizando las 18 fórmulas para generar ítems originales. La aplicación debe comercializarse como "Basada en la Axiología Formal de Hartman", no como el test oficial.',
    
    'cons_standards_title' => 'Estándares de Evaluación Psicológica',
    'cons_standards_content' => 'Una aplicación automatizada no reemplaza a un profesional cualificado. No debe pretender diagnosticar condiciones psicológicas. Debe posicionarse claramente como una herramienta educativa o de autoconocimiento, no de evaluación clínica. Los resultados automatizados no deben ser la única base para la toma de decisiones importantes.',
    
    'cons_privacy_title' => 'Privacidad de Datos y Consentimiento',
    'cons_privacy_content' => 'La aplicación debe cumplir con regulaciones como GDPR, manejando datos sensibles de forma segura (cifrado, almacenamiento seguro). Antes de empezar, se debe presentar un consentimiento informado claro, explicando qué datos se recogen, cómo se usan, los riesgos y las limitaciones de la evaluación.',
    
    'cons_disclaimer_title' => 'Descargo de Responsabilidad (Disclaimer)',
    'cons_disclaimer_content' => 'Es fundamental un descargo de responsabilidad visible que indique: 1. Fines educativos únicamente. 2. No es asesoramiento médico ni psicológico. 3. Sin garantías sobre los resultados. 4. La responsabilidad personal recae en el usuario. 5. Debe incluir enlaces a recursos de ayuda en crisis.',

    // Formulas descriptions
    'formula_Ii_name' => 'Un bebé', 'formula_Ii_desc' => 'Valorar lo Intrínseco intrínsecamente.',
    'formula_Ie_name' => 'Amor a la naturaleza', 'formula_Ie_desc' => 'Valorar lo Intrínseco extrínsecamente.',
    'formula_Is_name' => 'Una ceremonia de boda', 'formula_Is_desc' => 'Valorar lo Intrínseco sistémicamente.',
    'formula_Ei_name' => 'Un científico dedicado', 'formula_Ei_desc' => 'Valorar lo Extrínseco intrínsecamente.',
    'formula_Ee_name' => 'Una buena comida', 'formula_Ee_desc' => 'Valorar lo Extrínseco extrínsecamente.',
    'formula_Es_name' => 'Una línea de producción', 'formula_Es_desc' => 'Valorar lo Extrínseco sistémicamente.',
    'formula_Si_name' => 'Un genio matemático', 'formula_Si_desc' => 'Valorar lo Sistémico intrínsecamente.',
    'formula_Se_name' => 'Un mejoramiento técnico', 'formula_Se_desc' => 'Valorar lo Sistémico extrínsecamente.',
    'formula_Ss_name' => 'Un uniforme', 'formula_Ss_desc' => 'Valorar lo Sistémico sistémicamente.',
    'formula_-Ss_name' => 'Una idea absurda', 'formula_-Ss_desc' => 'Desvalorizar lo Sistémico sistémicamente.',
    'formula_-Se_name' => 'Una multa', 'formula_-Se_desc' => 'Desvalorizar lo Sistémico extrínsecamente.',
    'formula_-Si_name' => 'Hacer estallar un avión', 'formula_-Si_desc' => 'Desvalorizar lo Sistémico intrínsecamente.',
    'formula_-Es_name' => 'Un cortocircuito', 'formula_-Es_desc' => 'Desvalorizar lo Extrínseco sistémicamente.',
    'formula_-Ee_name' => 'Basura', 'formula_-Ee_desc' => 'Desvalorizar lo Extrínseco extrínsecamente.',
    'formula_-Ei_name' => 'Un chiflado', 'formula_-Ei_desc' => 'Desvalorizar lo Extrínseco intrínsecamente.',
    'formula_-Is_name' => 'Quemar un hereje', 'formula_-Is_desc' => 'Desvalorizar lo Intrínseco sistémicamente.',
    'formula_-Ie_name' => 'Esclavitud', 'formula_-Ie_desc' => 'Desvalorizar lo Intrínseco extrínsecamente.',
    'formula_-Ii_name' => 'Torturar una persona', 'formula_-Ii_desc' => 'Desvalorizar lo Intrínseco intrínsecamente.',
];
