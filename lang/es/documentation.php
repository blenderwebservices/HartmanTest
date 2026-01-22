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
    'formula_-Ii_name' => 'Torturar una persona',    'formula_-Ii_desc' => 'Desvalorizar lo Intrínseco intrínsecamente.',

    // Variables Axiológicas Classification
    'variables_title' => 'Variables Axiológicas',
    'variables_desc' => 'A continuación se detallan las variables del Inventario de Valores de Hartman (HVI), clasificadas por su función, significado, rangos de calificación y métodos de cálculo.',

    // Category 1
    'cat_1_title' => '1. Dimensiones de Valor (Puntajes de Base)',
    'cat_1_desc' => 'Representan las tres esferas en las que el ser humano procesa la realidad y los conceptos.',

    'var_dim_i_title' => 'Dimensión Intrínseca (Dim-I)',
    'var_dim_i_meaning' => 'Mide el desarrollo de la capacidad para discernir la individualidad y unicidad de las personas y de sí mismo (pensamiento empático).',
    'var_dim_i_range' => 'Se califica de Excelente (0-7) a Malo (43+).',
    'var_dim_i_calc' => 'Se obtiene sumando las desviaciones de los ítems correspondientes a esta dimensión en la prueba.',

    'var_dim_e_title' => 'Dimensión Extrínseca (Dim-E)',
    'var_dim_e_meaning' => 'Mide la capacidad para discernir valores prácticos, roles sociales y situaciones concretas (pensamiento pragmático).',
    'var_dim_e_range' => 'De Excelente (0-7) a Malo (43+).',
    'var_dim_e_calc' => 'Suma de desviaciones de los ítems de esta dimensión.',

    'var_dim_s_title' => 'Dimensión Sistémica (Dim-S)',
    'var_dim_s_meaning' => 'Mide la capacidad de discernir el sistema, orden, leyes y normatividad moral (pensamiento esquemático).',
    'var_dim_s_range' => 'De Excelente (0-7) a Malo (43+).',
    'var_dim_s_calc' => 'Suma de desviaciones de los ítems de esta dimensión.',

    // Category 2
    'cat_2_title' => '2. Puntuaciones Fundamentales de Juicio',
    'cat_2_desc' => 'Estas variables miden la calidad técnica de la percepción del valor del sujeto.',

    'var_dif_title' => 'Diferenciación (Dif)',
    'var_dif_meaning' => 'Mide la agudeza de la visión de valores o sensibilidad axiológica. Representa el error total del sujeto.',
    'var_dif_range' => '0 (perfecto) a 162 (invertido). Un puntaje de 0-30 es excelente.',
    'var_dif_calc' => 'Es la suma de todos los totales de las filas de dimensiones (Dim-I + Dim-E + Dim-S).',

    'var_dim_title' => 'Dimensión (Dim)',
    'var_dim_meaning' => 'Mide la capacidad de enfoque o sentido de proporción al valorar las dimensiones (detecta el "astigmatismo axiológico").',
    'var_dim_range' => 'Excelente (0-3) a Malo (24+).',
    'var_dim_calc' => 'Se identifica el total más alto de las tres subdimensiones (I, E, S) y se le restan los otros dos; la suma de esos resultados es el puntaje Dim.',

    'var_int_title' => 'Integración (Int)',
    'var_int_meaning' => 'Capacidad de ver totalidades (Gestalten) y discernir lo importante dentro de lo complejo.',
    'var_int_range' => 'Excelente (0-7) a Malo (43+).',
    'var_int_calc' => 'Suma de los totales de integración de las filas 6, 8 y 10 de la hoja de puntuación.',

    'var_dis_title' => 'Disimilitud (Dis)',
    'var_dis_meaning' => 'Capacidad para distinguir entre el bien y el mal, o entre valoraciones positivas y negativas (detecta "estrabismo axiológico").',
    'var_dis_range' => 'Idealmente 0; puede llegar teóricamente a 18 (siempre es un número par).',
    'var_dis_calc' => 'Mide la confusión entre composiciones (valoraciones) y transposiciones (devaluaciones).',

    // Category 3
    'cat_3_title' => '3. Índices Porcentuales (Subjetivos)',
    'cat_3_desc' => 'Relacionan la sensibilidad total con áreas específicas del desarrollo personal.',

    'var_dim_per_title' => 'Dimensión Porcentaje (Dim% - Índice Existencial)',
    'var_dim_per_meaning' => 'Desarrollo del sentido de la realidad del mundo y de sí mismo.',
    'var_dim_per_range' => 'Excelente (0-10) a Malo (61+).',
    'var_dim_per_calc' => '(Dim / Dif) × 100.',

    'var_int_per_title' => 'Integración Porcentaje (Int% - Índice Psicológico)',
    'var_int_per_meaning' => 'Capacidad de organizar y disciplinar las reacciones ante problemas.',
    'var_int_per_range' => 'Excelente (0-7.8) a Malo (46.9+).',
    'var_int_per_calc' => '(Int / Dif) × 100.',

    'var_ai_per_title' => 'Índice de Actitud (AI%)',
    'var_ai_per_meaning' => 'Refleja la actitud positiva o negativa hacia la realidad. Mide la carga de desvalorizaciones.',
    'var_ai_per_range' => 'El 50% es el equilibrio ideal; niveles sobre 70% indican hostilidad grave.',
    'var_ai_per_calc' => '(Suma de números negativos / Dif) × 100.',

    // Category 4
    'cat_4_title' => '4. Capacidades de Valoración y Equilibrio',
    'cat_4_desc' => 'Evalúan la efectividad del individuo en su interacción con el entorno y consigo mismo.',

    'var_vq_title' => 'Capacidad de Valoración (VQ)',
    'var_vq_meaning' => 'Capacidad para valorar situaciones del mundo externo. El primer número es cantidad y el segundo calidad.',
    'var_vq_range' => 'Cantidad (0-368); Calidad (0-43+).',
    'var_vq_calc' => 'Basado en las desviaciones de la Parte I de la prueba.',

    'var_sq_title' => 'Capacidad de Autovaloración (SQ)',
    'var_sq_meaning' => 'Capacidad para valorarse a sí mismo acertadamente.',
    'var_sq_range' => 'Mismas escalas que VQ.',
    'var_sq_calc' => 'Basado en las desviaciones de la Parte II de la prueba.',

    'var_bqr_title' => 'Equilibrio Relativo (BQr)',
    'var_bqr_meaning' => 'Balance entre la capacidad de valorar el mundo y a sí mismo. Indica madurez.',
    'var_bqr_range' => 'Idealmente 1.0; menor a 0.7 indica problemas para manejar el mundo exterior.',
    'var_bqr_calc' => 'Cociente entre SQ y VQ.',

    'var_cq_title' => 'Capacidad Combinada (CQ)',
    'var_cq_meaning' => 'Capacidad total de valoración.',
    'var_cq_range' => 'Excelente (0-83) a Malo (537+).',
    'var_cq_calc' => 'Producto de los índices de equilibrio absoluto y relativo (BQr × BQa).',

    'var_rho_title' => 'Número Índice rho (ρ)',
    'var_rho_meaning' => 'Coeficiente que correlaciona la secuencia del sujeto con la norma teórica; define la naturaleza total de la prueba.',
    'var_rho_range' => '+1.0 a -1.0. Significativo a partir de 0.475.',
    'var_rho_calc' => 'Aproximado: 1.000 - ΣD². Exacto: 1 - 6ΣD² / n(n²-1).',
];
