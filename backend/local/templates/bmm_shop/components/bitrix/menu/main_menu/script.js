menuVue = function(BMM_GLOBAL_MENU) {
	(async () => {
		BX.Vue.directive('scroll', {
			inserted: function (el, binding) {
			let f = function (evt) {
				if (binding.value(evt, el)) {
				el.removeEventListener('scroll', f)
				}
			}
			el.addEventListener('scroll', f)
			}
		});

		BX.Vue.component('zigzag', {
			props: ['w1', 'h', 'w2', 'reversed', 'color'],
			template: `<svg :width="(w1+w2)+'px'" :height="h > 0 ? h+'px' : '1px'">
					<path v-if="h === 0"
						:style="'fill: none; stroke: '+color+'; stroke-width: 1px;'"
						:d="'M 0,0 H ' + (w1+w2)"
					/>
					<path v-else-if="reversed"
						:style="'fill: none; stroke: '+color+'; stroke-width: 1px;'"
						:d="'M 0,' + h + ' H ' + w1 + ' v -' + h + ' h ' + w2"
					/>
					<path v-else
						:style="'fill: none; stroke: '+color+'; stroke-width: 1px;'"
						:d="'M 0,0 H ' + w1 + ' v ' + h + ' h ' + w2"
					/>
				</svg>`
		});

		BX.Vue.create({
			el: '#main-menu',
			template: `<nav class="header-menu__body" :class="{'header-menu__body_mobile': isMobile}">
				<div class="header-menu__scroll" v-scroll="syncSelectedTopMenuTrianglePosition" ref="level0ScrollEl">
				<ul class="header-menu__list">
					<li class="header-menu__link"
						:class="{'header-menu__link_active': index === levelIndex[0]}"
						v-for="(item, index) in menu" :key="'0'+item.TITLE"
						@click="event => setLevelIndex(0, index, event, 'click')"
					>
						<a :href="item.HREF" @hover="level1Index = index">{{item.TITLE}}</a>
						<div class="header-menu__pointer" v-if="index === levelIndex[0]" ref="hiddenPointer"></div>
					</li>
				</ul>
				</div>
				<div class="header-menu__pointer" v-if="levelIndex[0] !== null" :style="{left: pointerPositionX + 'px'}"></div>
				<div class="header-menu__scroll" ref="columnsScrollEl">
				<div class="header-submenu" v-if="levelIndex[0] !== null" :style="{width: (getColumnWidth() * 3)+'px'}">
					<ul class="header-submenu__list" :style="getLevelStyle(1)">
						<li class="header-menu__link"
							:class="{'header-menu__link_hover': index === levelIndex[1], 'header-menu__link_selected': isItemSelected(1, index)}"
							v-for="(item, index) in level1" :key="'1'+item.TITLE"
							@mouseover="setLevelIndex(1, index, null, 'hover')"
						>
							<a :href="item.HREF" @mouseover="setLevelIndex(1, index, null, 'hover')">{{item.TITLE}}</a>&nbsp;<a href="#" class="header-menu__submenu" @click="setLevelIndex(1, index, null, 'click')">&#8594;</a>
							<zigzag v-if="isItemSelected(1, index) && isDesktop"
								:w1="l1w1"
								:h="l1h"
								:w2="l1w2"
								:reversed="l1reversed"
								:class="{'header-menu__zigzag_reversed': l1reversed}"
								color="#818181"
							></zigzag>
						</li>
					</ul>
					<ul class="header-submenu__list" v-if="levelIndex[1] !== null" :style="getLevelStyle(2)">
						<li class="header-menu__link header-menu__link_back" @click="gotoLevel(1)" v-if="isMobile">
							<img src="/images/menu-arrow-back-mobile.svg"> Назад
						</li>
						<li class="header-menu__link"
							:class="{'header-menu__link_hover': index === levelIndex[2], 'header-menu__link_selected': isItemSelected(2, index)}"
							v-for="(item, index) in level2" :key="'2'+item.TITLE"
							@mouseover="setLevelIndex(2, index, null, 'hover')"
						>
							<a :href="item.HREF" @mouseover="setLevelIndex(2, index, null, 'hover')">{{item.TITLE}}</a>&nbsp;<a href="#" class="header-menu__submenu" @click="setLevelIndex(2, index, null, 'click')">&#8594;</a>
							<zigzag v-if="isItemSelected(2, index) && isDesktop"
								:w1="l2w1"
								:h="l2h"
								:w2="l2w2"
								:reversed="l2reversed"
								:class="{'header-menu__zigzag_reversed': l2reversed}"
								color="#818181"
							></zigzag>
						</li>
					</ul>
					<ul class="header-submenu__list" v-if="levelIndex[2] !== null" :style="getLevelStyle(3)">
						<li class="header-menu__link header-menu__link_back" @click="gotoLevel(2)" v-if="isMobile">
							<img src="/images/menu-arrow-back-mobile.svg"> Назад
						</li>
						<li class="header-menu__link"
							:class="{'header-menu__link_hover': index === levelIndex[3]}"
							v-for="(item, index) in level3" :key="'3'+item.TITLE"
							@mouseover="setLevelIndex(3, index, null, 'hover')"
						>
							<a :href="item.HREF" @mouseover="setLevelIndex(3, index, null, 'hover')">{{item.TITLE}}</a>
						</li>
					</ul>
				</div>
				</div>
				</nav>`,
			data: {
				menu: BMM_GLOBAL_MENU,
				levelIndex: [null, null, null, null],
				hoverIndex: [null, null, null, null],
				levelSelectPositions: [null, null, null],
				levelHoverPositions: [null, null, null],
				level0ScrollX: 0,
				hiddenPointerPositionX: 0,
				clientWidth: 0,
				mobileBreakpoint: 575,
				tabletBreakpoint: 768,
				menuX: 0,
				menuSize: 0,
			},
			mounted() {
				window.addEventListener('resize', this.handleResize);
				this.handleResize();
			},
			beforeDestroy () {
				window.removeEventListener('resize', this.handleResize)
			},
			methods: {
				updateElementBoundingRecs() {
					for (let i=1; i<=3; i++) {
						this.levelSelectPositions[i - 1] = this.getLevelSelectedPosition(i);
						this.levelHoverPositions[i - 1] = this.getLevelHoverPosition(i);
					}
				},
				setLevelIndex(level, index, event, eventType) {
					let disableSelectedMenu = level === 0 && this.levelIndex[level] === index;
					let item = this.getLevelItem(level, index);
					let menuTriggerHrefs = ['books', 'non-books'];
					let itemIsTrigger = item && menuTriggerHrefs.some(triggerHref => item.HREF.indexOf(triggerHref) !== -1);

					if (level === 0 && !itemIsTrigger) {
						return;
					}

					if (!this.isDesktop && eventType === 'hover') {
						return;
					}

					if (event) {
						event.preventDefault();
						event.stopPropagation();
					}

					this.$set(this.levelIndex, level, disableSelectedMenu ? null : index);

					if (level === 0) {
						this.setLevelIndex(1, null);
					}

					if (level === 1) {
						this.setLevelIndex(2, null);
					}

					if (level === 2) {
						this.setLevelIndex(3, null);
					}

					if (index !== null) {
						this.scrollToLevel(level+1);
					}

					this.$nextTick(() => {
						this.updateElementBoundingRecs();
						this.syncSelectedTopMenuTrianglePosition();
					});
				},
				setHoverIndex(level, index) {
					this.$set(this.hoverIndex, level, index);

					if (level === 0) {
						this.setHoverIndex(1, null);
					}

					if (level === 1) {
						this.setHoverIndex(2, null);
					}

					if (level === 2) {
						this.setHoverIndex(3, null);
					}

					this.$nextTick(() => {
						this.updateElementBoundingRecs();
					});
				},
				isItemSelected(level, index) {
					return index === this.levelIndex[level] && this.levelIndex[level+1] !== null;
				},
				getLevelActiveElementPosition(activeClass, level) {
					let textEl = document.querySelector(`.header-submenu__list:nth-child(${level}) ${activeClass} a:first-of-type`);
					let arrowEl = document.querySelector(`.header-submenu__list:nth-child(${level}) ${activeClass} a:last-of-type`);

					if (!textEl || !arrowEl) {
						return null;
					}

					let textRect = textEl.getBoundingClientRect();
					let arrowRect = arrowEl.getBoundingClientRect();

					return {
						left: textRect.left,
						right: arrowRect.right,
						top: arrowRect.top,
						firstLineTop: textRect.top,
						secondLineTop: arrowRect.top,
						bottom: textRect.bottom,
						width: arrowRect.right - textRect.left,
						height: textRect.height,
						x: textRect.left,
						y: arrowRect.top
					};
				},

				getLevelSelectedPosition(level) {
					return this.getLevelActiveElementPosition('.header-menu__link_selected', level);
				},
				getLevelHoverPosition(level) {
					return this.getLevelActiveElementPosition('.header-menu__link_hover', level);
				},
				getLevelZigzag(level) {
					let selected = this.levelSelectPositions[level-1] !== null
						? this.levelSelectPositions[level-1]
						: null;
					let hover = this.levelHoverPositions[level] !== null
						? this.levelHoverPositions[level]
						: null;

					if (hover === null || selected === null) {
						return null;
					}

					let margins = 8;
					let width = hover.left - selected.right - margins;
					let w2 = 16;
					let w1 = width - w2;
					let h = hover.firstLineTop - selected.secondLineTop;
					return {w1, h: Math.abs(h), w2, reversed: h < 0}
				},
				getLevelZigzagProp(level, prop, defaultValue) {
					let hasActiveItem = this.levelIndex[level] !== null;
					let zigzagProps = this.getLevelZigzag(level);
					return hasActiveItem && zigzagProps ? zigzagProps[prop] || defaultValue : defaultValue;
				},
				syncSelectedTopMenuTrianglePosition() {
					this.hiddenPointerPositionX = this.$refs.hiddenPointer && this.$refs.hiddenPointer[0]
						? this.$refs.hiddenPointer[0].getBoundingClientRect().left
						: 0;
				},
				syncMenuSize() {
					this.menuX = this.$refs.level0ScrollEl.getBoundingClientRect().left;
					this.menuSize = this.$refs.level0ScrollEl.getBoundingClientRect().width;
				},
				handleResize() {
					this.clientWidth = window.innerWidth;
					this.syncMenuSize();
					this.syncSelectedTopMenuTrianglePosition();
				},
				getColumnWidth() {
					if (!this.menuSize) {
						return 0;
					}

					if (this.isMobile) {
						return this.menuSize;
					}
					else if (this.isTablet) {
						return this.menuSize / 2;
					}
					else {
						return this.menuSize / 3;
					}
				},
				getLevelStyle(level) {
					let style = {
						width: this.getColumnWidth().toFixed(2) + 'px',
					}

					if (this.isMobile) {
						let levelName = 'level' + level;
						let isLevelActive = this[levelName];
						if (!isLevelActive) {
							style = {
								display: 'none',
							}
						}
					}

					return style;
				},
				scrollToLevel(level) {
					let scrollPosition = 0;

					if (level > 0) {
						scrollPosition = this.getColumnWidth() * (level - 1);
						if (this.isTablet) {
							scrollPosition = scrollPosition - this.getColumnWidth() * 0.5;
						}
					}

					this.$refs.columnsScrollEl.scrollTo(scrollPosition, 0);
				},
				gotoLevel(newLevel) {
					this.setLevelIndex(newLevel, null);
					this.scrollToLevel(newLevel);
				},
				getLevelRecursive(indexes) {
					let items = this.menu;

					for (const index of indexes) {
						if (index !== null && items[index] && items[index].CHILDREN) {
							items = items[index].CHILDREN;
						}
					}

					return items;
				},
				getLevelItem(level, index) {
					let indexesToGetLevelItems = this.levelIndex.slice();
					let totalLevels = this.levelIndex.length;
					for (let i = level; i < totalLevels; i++) {
						indexesToGetLevelItems[i] = null;
					}

					let levelItems = this.getLevelRecursive(indexesToGetLevelItems);

					return levelItems && levelItems[index] ? levelItems[index] : null;
				}
			},
			computed: {
				level1() {
					if (this.levelIndex[0] === null) {
						return null;
					}

					return this.menu[this.levelIndex[0]]
						? this.menu[this.levelIndex[0]].CHILDREN || null
						: null;
				},
				level2() {
					if (this.level1 === null) {
						return null;
					}

					if (this.levelIndex[1] === null) {
						return null;
					}

					return this.level1[this.levelIndex[1]]
						? this.level1[this.levelIndex[1]].CHILDREN || null
						: null;
				},
				level3() {
					if (this.level2 === null) {
						return null;
					}

					if (this.levelIndex[1] === null) {
						return null;
					}

					return this.level2[this.levelIndex[2]]
						? this.level2[this.levelIndex[2]].CHILDREN || null
						: null;
				},
				l1w1() {
					return this.getLevelZigzagProp(1, 'w1', 0);
				},
				l1h() {
					return this.getLevelZigzagProp(1, 'h', 0);
				},
				l1w2() {
					return this.getLevelZigzagProp(1, 'w2', 0);
				},
				l1reversed() {
					return this.getLevelZigzagProp(1, 'reversed', false);
				},
				l2w1() {
					return this.getLevelZigzagProp(2, 'w1', 0);
				},
				l2h() {
					return this.getLevelZigzagProp(2, 'h', 0);
				},
				l2w2() {
					return this.getLevelZigzagProp(2, 'w2', 0);
				},
				l2reversed() {
					return this.getLevelZigzagProp(2, 'reversed', false);
				},
				pointerPositionX() {
					return this.hiddenPointerPositionX - this.menuX;
				},
				isMobile() {
					return this.clientWidth <= this.mobileBreakpoint;
				},
				isTablet() {
					return this.clientWidth <= this.tabletBreakpoint && this.clientWidth >= this.mobileBreakpoint;
				},
				isDesktop() {
					return this.clientWidth > this.tabletBreakpoint;
				}
			}
		})
	})();
}
