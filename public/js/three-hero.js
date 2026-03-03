/**
 * Three.js Hero — Particle Scene
 * Lightweight 3D particle background for the hero section.
 * Auto-stops rendering when hero is out of viewport or page is hidden.
 */

(function () {
    'use strict';

    // Wait for Three.js to load
    if (typeof THREE === 'undefined') {
        console.warn('Three.js not loaded');
        return;
    }

    const canvas = document.getElementById('heroCanvas');
    if (!canvas) return;

    // ---- Scene Setup ----
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(
        60,
        window.innerWidth / window.innerHeight,
        0.1,
        100
    );
    camera.position.z = 3;

    const renderer = new THREE.WebGLRenderer({
        canvas: canvas,
        antialias: false,
        alpha: true,
        powerPreference: 'low-power',
    });
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 1.5));
    renderer.setClearColor(0x000000, 0);

    // ---- Particles ----
    const PARTICLE_COUNT = 40;
    const geometry = new THREE.BufferGeometry();
    const positions = new Float32Array(PARTICLE_COUNT * 3);
    const velocities = new Float32Array(PARTICLE_COUNT * 3);

    for (let i = 0; i < PARTICLE_COUNT; i++) {
        const i3 = i * 3;
        positions[i3] = (Math.random() - 0.5) * 6;
        positions[i3 + 1] = (Math.random() - 0.5) * 6;
        positions[i3 + 2] = (Math.random() - 0.5) * 4;

        velocities[i3] = (Math.random() - 0.5) * 0.003;
        velocities[i3 + 1] = (Math.random() - 0.5) * 0.003;
        velocities[i3 + 2] = (Math.random() - 0.5) * 0.002;
    }

    geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));

    const material = new THREE.PointsMaterial({
        color: 0xc9a96e,
        size: 0.04,
        transparent: true,
        opacity: 0.6,
        sizeAttenuation: true,
    });

    const particles = new THREE.Points(geometry, material);
    scene.add(particles);

    // ---- Gentle connecting lines (optional, very few) ----
    const lineGeometry = new THREE.BufferGeometry();
    const linePositions = new Float32Array(20 * 6); // max 20 lines
    lineGeometry.setAttribute('position', new THREE.BufferAttribute(linePositions, 3));

    const lineMaterial = new THREE.LineBasicMaterial({
        color: 0xc9a96e,
        transparent: true,
        opacity: 0.08,
    });

    const lines = new THREE.LineSegments(lineGeometry, lineMaterial);
    scene.add(lines);

    // ---- Animation State ----
    let isRendering = true;
    let animationFrameId = null;

    function animate() {
        if (!isRendering) return;
        animationFrameId = requestAnimationFrame(animate);

        // Update particle positions
        const posArray = geometry.attributes.position.array;
        for (let i = 0; i < PARTICLE_COUNT; i++) {
            const i3 = i * 3;
            posArray[i3] += velocities[i3];
            posArray[i3 + 1] += velocities[i3 + 1];
            posArray[i3 + 2] += velocities[i3 + 2];

            // Boundary wrap
            for (let j = 0; j < 3; j++) {
                if (Math.abs(posArray[i3 + j]) > 3) {
                    velocities[i3 + j] *= -1;
                }
            }
        }
        geometry.attributes.position.needsUpdate = true;

        // Update connecting lines (connect near particles)
        const lp = lineGeometry.attributes.position.array;
        let lineIndex = 0;
        const maxDist = 1.5;

        for (let i = 0; i < Math.min(PARTICLE_COUNT, 15); i++) {
            for (let j = i + 1; j < Math.min(PARTICLE_COUNT, 15); j++) {
                if (lineIndex >= 20) break;
                const i3 = i * 3;
                const j3 = j * 3;
                const dx = posArray[i3] - posArray[j3];
                const dy = posArray[i3 + 1] - posArray[j3 + 1];
                const dz = posArray[i3 + 2] - posArray[j3 + 2];
                const dist = Math.sqrt(dx * dx + dy * dy + dz * dz);

                if (dist < maxDist) {
                    const li = lineIndex * 6;
                    lp[li] = posArray[i3];
                    lp[li + 1] = posArray[i3 + 1];
                    lp[li + 2] = posArray[i3 + 2];
                    lp[li + 3] = posArray[j3];
                    lp[li + 4] = posArray[j3 + 1];
                    lp[li + 5] = posArray[j3 + 2];
                    lineIndex++;
                }
            }
        }

        // Clear unused lines
        for (let i = lineIndex * 6; i < lp.length; i++) {
            lp[i] = 0;
        }
        lineGeometry.attributes.position.needsUpdate = true;

        // Gentle camera rotation
        camera.rotation.y += 0.0003;
        camera.rotation.x += 0.0001;

        renderer.render(scene, camera);
    }

    function startRendering() {
        if (!isRendering) {
            isRendering = true;
            animate();
        }
    }

    function stopRendering() {
        isRendering = false;
        if (animationFrameId) {
            cancelAnimationFrame(animationFrameId);
            animationFrameId = null;
        }
    }

    // ---- Start ----
    animate();

    // ---- Resize handling ----
    let resizeTimeout;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function () {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        }, 200);
    });

    // ---- Visibility API: stop when tab hidden ----
    document.addEventListener('visibilitychange', function () {
        if (document.hidden) {
            stopRendering();
        } else {
            const hero = document.getElementById('hero');
            if (hero && !hero.classList.contains('hero-exit')) {
                startRendering();
            }
        }
    });

    // ---- IntersectionObserver: stop when hero out of viewport ----
    const heroEl = document.getElementById('hero');
    if (heroEl && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        startRendering();
                    } else {
                        stopRendering();
                    }
                });
            },
            { threshold: 0.1 }
        );
        observer.observe(heroEl);
    }

    // ---- "Buka Undangan" click: camera zoom ----
    const openBtn = document.getElementById('openInvitation');
    if (openBtn) {
        openBtn.addEventListener('click', function () {
            // Camera zoom out effect
            let startZ = camera.position.z;
            let targetZ = startZ + 1;
            let startTime = performance.now();
            let duration = 800;

            function zoomOut(now) {
                let elapsed = now - startTime;
                let progress = Math.min(elapsed / duration, 1);
                // Ease out quad
                progress = 1 - (1 - progress) * (1 - progress);
                camera.position.z = startZ + (targetZ - startZ) * progress;

                if (elapsed < duration) {
                    requestAnimationFrame(zoomOut);
                } else {
                    // Stop rendering after zoom completes
                    setTimeout(stopRendering, 300);
                }
            }
            requestAnimationFrame(zoomOut);
        });
    }

    // ---- Cleanup exposed for potential use ----
    window._heroCleanup = function () {
        stopRendering();
        geometry.dispose();
        material.dispose();
        lineGeometry.dispose();
        lineMaterial.dispose();
        renderer.dispose();
    };
})();
