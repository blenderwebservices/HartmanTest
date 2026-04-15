# Hartman Value Profile (HVP) - Codexia Hub

## Descripción del Proyecto
Esta aplicación es una implementación digital avanzada del **Test de Hartman** (Hartman Value Profile - HVP), una herramienta científica basada en la axiología formal desarrollada por el Dr. Robert S. Hartman. A diferencia de los tests de personalidad tradicionales, este test mide la estructura de los juicios de valor de un individuo, permitiendo entender cómo perciben la realidad externa y su propio yo.

## ¿A quién está dirigida?
La plataforma está diseñada para:
*   **Departamentos de Recursos Humanos**: Para procesos de selección de personal alineados con los valores culturales de la empresa.
*   **Consultores y Coaches**: Como herramienta base para procesos de desarrollo profesional y personal.
*   **Empresas (Codexia Hub)**: Para la gestión interna del talento y optimización de equipos.
*   **Individuos**: Que buscan un mayor autoconocimiento sobre sus capacidades de juicio y toma de decisiones.

## Resultados y Variables Calculadas
El sistema procesa los rankings de los usuarios para generar un perfil técnico completo que incluye:
*   **DIF (Desviación Total)**: Sensibilidad axiológica general.
*   **DIM_I, DIM_E, DIM_S**: Claridad en las dimensiones Intrínseca (personas), Extrínseca (cosas/roles) y Sistémica (ideas).
*   **Dim (Dimensión)**: Capacidad de enfoque y equilibrio entre dimensiones.
*   **Int (Integración)**: Habilidad para ver el "todo" y resolver problemas complejos.
*   **Dis (Disimilitud)**: Capacidad de distinguir entre valoraciones positivas y negativas.
*   **Índices Porcentuales (Dim%, Int%, AI%)**: Indicadores existenciales y psicológicos de la actitud del individuo.
*   **Rho (ρ)**: Correlación con la norma teórica objetiva.

## Integración con Inteligencia Artificial (IA)
La aplicación utiliza modelos avanzados de lenguaje (LLMs) a través de **Laravel AI** para:
*   **Interpretación Automatizada**: Transforma los datos técnicos en una narrativa comprensible y profesional.
*   **Diagnóstico Profundo**: Identifica patrones de comportamiento, fortalezas y áreas de mejora basadas en la estructura axiológica.
*   **Soporte a la Decisión**: Ayuda a los reclutadores a filtrar candidatos basándose en interpretaciones cualitativas de alto nivel.

## Stack Tecnológico
*   **Backend**: Laravel 13 + PHP 8.3
*   **Panel Administrativo**: Filament 4.0
*   **Frontend**: Livewire Volt + Alpine.js + Tailwind CSS
*   **IA**: Integración con Laravel AI (OpenAI/Anthropic)
*   **Reportes**: DomPDF para generación de diagnósticos en PDF.

## Arquitectura y Despliegue
El sistema está diseñado para ejecutarse en un entorno empresarial robusto:
*   **Plataforma**: IONOS Cloud.
*   **Panel de Control**: Plesk.
*   **Sistema Operativo**: CentOS 8 (Stream).
*   **Servidor Web**: Nginx / Apache configurado para alta disponibilidad.

## Base de Datos
*   **Actual**: MySQL / MariaDB para almacenamiento relacional de perfiles, resultados y rankings.
*   **Futura**: Implementación de bases de datos vectoriales para análisis comparativos avanzados y almacenamiento de embeddings de perfiles psicológicos.

## Visión a Futuro y Codexia Hub
Este proyecto es un pilar fundamental dentro del ecosistema de **Codexia Hub**. La visión a futuro incluye:
*   **Centralización**: Integración total como módulo de talento dentro de Codexia Hub.
*   **Talent Matching**: Algoritmos avanzados que crucen perfiles axiológicos con requerimientos de puestos específicos.
*   **Evolución del Producto**: Desarrollo de nuevas versiones del test (Hartman 2.0) con mayor interactividad e interpretación en tiempo real mediante agentes de IA autónomos.

---
© 2026 Codexia Hub. Todos los derechos reservados.
